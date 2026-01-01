<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Models\StringSet;
use App\Models\User;

test('can create a string set', function (): void {
    $brand = Brand::factory()->create();
    $user = User::factory()->create();

    $stringSet = StringSet::factory()->create([
        'brand_id' => $brand->id,
        'name' => 'Test String Set',
        'product_code' => 'TS-12345',
        'winding_length' => 32.50,
        'number_of_strings' => 6,
        'high_gauge' => '45',
        'low_gauge' => '105',
        'created_by' => $user->id,
    ]);

    expect($stringSet->name)->toBe('Test String Set')
        ->and($stringSet->product_code)->toBe('TS-12345')
        ->and($stringSet->winding_length)->toBe(32.50)
        ->and($stringSet->number_of_strings)->toBe(6)
        ->and($stringSet->high_gauge)->toBe(45)
        ->and($stringSet->low_gauge)->toBe(105)
        ->and($stringSet->id)->toBeString();
});

test('string set uses uuid as primary key', function (): void {
    $stringSet = StringSet::factory()->create();

    expect($stringSet->id)
        ->toBeString()
        ->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/');
});

test('winding_length handles null values', function (): void {
    $stringSet = StringSet::factory()->create(['winding_length' => null]);

    expect($stringSet->winding_length)->toBeNull();
});

test('winding_length can be set to null', function (): void {
    $stringSet = StringSet::factory()->create(['winding_length' => 32.50]);
    $stringSet->winding_length = null;
    $stringSet->save();
    $stringSet->refresh();

    expect($stringSet->winding_length)->toBeNull()
        ->and($stringSet->getAttributes()['winding_length'])->toBeNull();
});

test('string set belongs to a brand', function (): void {
    $brand = Brand::factory()->create();
    $stringSet = StringSet::factory()->create(['brand_id' => $brand->id]);

    expect($stringSet->brand)->toBeInstanceOf(Brand::class)
        ->and($stringSet->brand->id)->toBe($brand->id);
});

test('string set has a creator', function (): void {
    $user = User::factory()->create();
    $stringSet = StringSet::factory()->create(['created_by' => $user->id]);

    expect($stringSet->creator)->toBeInstanceOf(User::class)
        ->and($stringSet->creator->id)->toBe($user->id);
});

test('string set creator is optional', function (): void {
    $stringSet = StringSet::factory()->create(['created_by' => null]);

    expect($stringSet->created_by)->toBeNull()
        ->and($stringSet->creator)->toBeNull();
});

test('string set product_code is optional', function (): void {
    $stringSet = StringSet::factory()->create(['product_code' => null]);

    expect($stringSet->product_code)->toBeNull();
});

test('string set number_of_strings is optional', function (): void {
    $stringSet = StringSet::factory()->create(['number_of_strings' => null]);

    expect($stringSet->number_of_strings)->toBeNull();
});

test('string set high_gauge is optional', function (): void {
    $stringSet = StringSet::factory()->create(['high_gauge' => null]);

    expect($stringSet->high_gauge)->toBeNull();
});

test('string set low_gauge is optional', function (): void {
    $stringSet = StringSet::factory()->create(['low_gauge' => null]);

    expect($stringSet->low_gauge)->toBeNull();
});

test('string set has timestamps', function (): void {
    $stringSet = StringSet::factory()->create();

    expect($stringSet->created_at)->not->toBeNull()
        ->and($stringSet->updated_at)->not->toBeNull();
});

test('string set creator relationship is nullified when user is deleted', function (): void {
    $user = User::factory()->create();
    $stringSet = StringSet::factory()->create(['created_by' => $user->id]);

    $user->delete();
    $stringSet->refresh();

    expect($stringSet->created_by)->toBeNull();
});
