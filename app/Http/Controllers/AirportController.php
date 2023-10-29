<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;
use App\Services\AirportValidationService;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Airport API Documentation",
 *      description="API documentation for Airport Management",
 *      @OA\Contact(
 *          email="devahmad92@gmail.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Server(
 *      url="http://localhost:8080",
 *      description="Development Server"
 * )
 *
 * @OA\Schema(
 *      schema="Airport",
 *      type="object",
 *      title="Airport",
 *      description="Airport model",
 *      @OA\Property(
 *          property="id",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="iata_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          type="number",
 *          format="float"
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          type="number",
 *          format="float"
 *      ),
 *      @OA\Property(
 *          property="terms_conditions",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="translations",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/AirportTranslation")
 *      )
 * )
 *
 * @OA\Schema(
 *      schema="AirportRequest",
 *      type="object",
 *      title="Airport Request",
 *      description="Request body for Airport",
 *      @OA\Property(
 *          property="iata_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="latitude",
 *          type="number",
 *          format="float"
 *      ),
 *      @OA\Property(
 *          property="longitude",
 *          type="number",
 *          format="float"
 *      ),
 *      @OA\Property(
 *          property="terms_conditions",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="translations",
 *          type="array",
 *          @OA\Items(ref="#/components/schemas/AirportTranslation")
 *      )
 * )
 *
 * @OA\Schema(
 *      schema="AirportTranslation",
 *      type="object",
 *      title="Airport Translation",
 *      description="Translations for the Airport model",
 *      @OA\Property(
 *          property="language_code",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="name",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="description",
 *          type="string"
 *      )
 * )
 */
class AirportController extends Controller
{
    protected $validationService;

    public function __construct(AirportValidationService $validationService)
    {
        $this->validationService = $validationService;
    }

    /**
     * @OA\Get(
     *     path="/airports/{id}",
     *     summary="Get a single airport",
     *     tags={"Airports"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Airport ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(ref="#/components/schemas/Airport")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID format"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airport not found"
     *     )
     * )
     */
    public function show($id)
    {
        if (!is_numeric($id)) {
            return response()->json(['error' => 'Invalid ID format'], 400);
        }

        $airport = Airport::with('translations')->find($id);

        if (!$airport) {
            return response()->json(['error' => 'Airport not found'], 404);
        }

        return response()->json($airport);
    }

    /**
     * @OA\Post(
     *     path="/airports",
     *     summary="Add a new airport",
     *     tags={"Airports"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass airport data",
     *         @OA\JsonContent(ref="#/components/schemas/AirportRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Airport created",
     *         @OA\JsonContent(ref="#/components/schemas/Airport")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request)
    {
        try {
            $data = $this->validationService->validateAirport($request->all());
            $airportData = Arr::only($data, ['iata_code', 'latitude', 'longitude', 'terms_conditions']);
            $airport = Airport::create($airportData);

            if (isset($data['translations'])) {
                foreach ($data['translations'] as $translationData) {
                    $airport->translations()->create($translationData);
                }
            }
            return response()->json($airport->load('translations'), 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Put(
     *     path="/airports/{id}",
     *     summary="Update an existing airport",
     *     tags={"Airports"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Airport ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass airport updated data",
     *         @OA\JsonContent(ref="#/components/schemas/AirportRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Airport updated",
     *         @OA\JsonContent(ref="#/components/schemas/Airport")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airport not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $airport = Airport::with('translations')->find($id);

        if (!$airport) {
            return response()->json(['error' => 'Airport not found'], 404);
        }

        try {
            $data = $this->validationService->validateAirport($request->all(), $id);
            $airportData = Arr::only($data, ['iata_code', 'latitude', 'longitude', 'terms_conditions']);
            $airport->update($airportData);

            if (isset($data['translations'])) {
                foreach ($data['translations'] as $translationData) {
                    $airport->translations()
                        ->updateOrCreate(
                            ['language_code' => $translationData['language_code']],
                            ['name' => $translationData['name'], 'description' => $translationData['description']]
                        );
                }
            }
            return response()->json($airport->load('translations'));
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * @OA\Delete(
     *     path="/airports/{id}",
     *     summary="Delete an airport",
     *     tags={"Airports"},
     *     @OA\Parameter(
     *         name="id",
     *         description="Airport ID",
     *         required=true,
     *         in="path",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Airport deleted"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Airport not found"
     *     )
     * )
     */
    public function destroy($id)
    {
        $airport = Airport::find($id);

        if (!$airport) {
            return response()->json(['error' => 'Airport not found'], 404);
        }

        $airport->delete();

        return response(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/airports",
     *     summary="List all airports",
     *     tags={"Airports"},
     *     @OA\Parameter(
     *         name="per_page",
     *         description="Number of items to return per page",
     *         required=false,
     *         in="query",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Airport"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Default is 10 if 'per_page' query param is not provided

        // Validate the 'per_page' input to ensure it's a number and not too large
        $validatedData = Validator::make(['per_page' => $perPage], [
            'per_page' => 'integer|min:1|max:100' // max 100 per page
        ])->validate();

        $airports = Airport::with('translations')->paginate($validatedData['per_page']);

        return response()->json($airports);
    }
}
