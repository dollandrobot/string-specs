<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\QueryException;

test('can create a brand', function (): void {
    $brand = Brand::factory()->create([
        'name' => 'Test Brand',
        'website' => 'https://example.com',
        'country_code' => 'US',
    ]);

    expect($brand->name)->toBe('Test Brand')
        ->and($brand->website)->toBe('https://example.com')
        ->and($brand->country_code)->toBe('US')
        ->and($brand->id)->toBeString();
});

test('brand uses uuid as primary key', function (): void {
    $brand = Brand::factory()->create();

    expect($brand->id)
        ->toBeString()
        ->toMatch('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/');
});

test('brand name is unique', function (): void {
    Brand::factory()->create(['name' => 'Unique Brand']);

    expect(fn () => Brand::factory()->create(['name' => 'Unique Brand']))
        ->toThrow(QueryException::class);
});

test('brand website is optional', function (): void {
    $brand = Brand::factory()->create(['website' => null]);

    expect($brand->website)->toBeNull();
});

test('brand country_code is optional', function (): void {
    $brand = Brand::factory()->create(['country_code' => null]);

    expect($brand->country_code)->toBeNull();
});

test('brand logo_path is optional', function (): void {
    $brand = Brand::factory()->create(['logo_path' => null]);

    expect($brand->logo_path)->toBeNull();
});

test('brand has timestamps', function (): void {
    $brand = Brand::factory()->create();

    expect($brand->created_at)->not->toBeNull()
        ->and($brand->updated_at)->not->toBeNull();
});

test('brand can have a creator', function (): void {
    $user = User::factory()->create();
    $brand = Brand::factory()->create(['created_by' => $user->id]);

    expect($brand->created_by)->toBe($user->id)
        ->and($brand->creator)->toBeInstanceOf(User::class)
        ->and($brand->creator->id)->toBe($user->id);
});

test('brand created_by is optional', function (): void {
    $brand = Brand::factory()->create(['created_by' => null]);

    expect($brand->created_by)->toBeNull()
        ->and($brand->creator)->toBeNull();
});

test('brand creator relationship is nullified when user is deleted', function (): void {
    $user = User::factory()->create();
    $brand = Brand::factory()->create(['created_by' => $user->id]);

    $user->delete();
    $brand->refresh();

    expect($brand->created_by)->toBeNull();
});
