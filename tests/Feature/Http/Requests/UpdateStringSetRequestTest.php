<?php

declare(strict_types=1);

use App\Http\Requests\UpdateStringSetRequest;
use App\Models\Brand;
use Illuminate\Support\Facades\Validator;

test('validates brand_id is required', function (): void {
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['name' => 'Test'],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('brand_id'))->toBeTrue();
});

test('validates brand_id must be a valid uuid', function (): void {
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => 'invalid-uuid', 'name' => 'Test'],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('brand_id'))->toBeTrue();
});

test('validates brand_id must exist in brands table', function (): void {
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => '01234567-89ab-cdef-0123-456789abcdef', 'name' => 'Test'],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('brand_id'))->toBeTrue();
});

test('validates name is required', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => $brand->id],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('name'))->toBeTrue();
});

test('validates name must be a string', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => $brand->id, 'name' => 123],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('name'))->toBeTrue();
});

test('validates name max length is 255', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => $brand->id, 'name' => str_repeat('a', 256)],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('name'))->toBeTrue();
});

test('validates product_code is optional', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => $brand->id, 'name' => 'Test'],
        $request->rules()
    );

    expect($validator->passes())->toBeTrue();
});

test('validates winding_length must be at least 100', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => $brand->id, 'name' => 'Test', 'winding_length' => 99],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('winding_length'))->toBeTrue();
});

test('validates winding_length must be at most 6000', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        ['brand_id' => $brand->id, 'name' => 'Test', 'winding_length' => 6001],
        $request->rules()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('winding_length'))->toBeTrue();
});

test('validates lowest_string_gauge must be greater than highest_string_gauge', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        [
            'brand_id' => $brand->id,
            'name' => 'Test',
            'highest_string_gauge' => 50,
            'lowest_string_gauge' => 40,
        ],
        $request->rules(),
        $request->messages()
    );

    expect($validator->fails())->toBeTrue()
        ->and($validator->errors()->has('lowest_string_gauge'))->toBeTrue()
        ->and($validator->errors()->first('lowest_string_gauge'))
        ->toBe('The low string gauge must be greater than the high string gauge.');
});

test('validates all fields with valid data', function (): void {
    $brand = Brand::factory()->create();
    $request = new UpdateStringSetRequest;
    $validator = Validator::make(
        [
            'brand_id' => $brand->id,
            'name' => 'Test String Set',
            'product_code' => 'TS-12345',
            'winding_length' => 3250,
            'number_of_strings' => 6,
            'highest_string_gauge' => 9,
            'lowest_string_gauge' => 46,
        ],
        $request->rules()
    );

    expect($validator->passes())->toBeTrue();
});

test('authorize returns true', function (): void {
    $request = new UpdateStringSetRequest;

    expect($request->authorize())->toBeTrue();
});
