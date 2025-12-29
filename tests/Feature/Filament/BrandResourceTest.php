<?php

declare(strict_types=1);

use App\Filament\Resources\Brands\Pages\CreateBrand;
use App\Filament\Resources\Brands\Pages\EditBrand;
use App\Filament\Resources\Brands\Pages\ListBrands;
use App\Models\Brand;
use App\Models\User;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->actingAs(User::factory()->create());
});

test('can render brand list page', function (): void {
    Livewire::test(ListBrands::class)
        ->assertOk();
});

test('can list brands', function (): void {
    $brands = Brand::factory()->count(10)->create();

    Livewire::test(ListBrands::class)
        ->assertCanSeeTableRecords($brands);
});

test('can render brand create page', function (): void {
    Livewire::test(CreateBrand::class)
        ->assertOk();
});

test('can create brand', function (): void {
    $newData = Brand::factory()->make();

    Livewire::test(CreateBrand::class)
        ->fillForm([
            'name' => $newData->name,
            'website' => $newData->website,
            'country_code' => $newData->country_code,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Brand::class, [
        'name' => $newData->name,
        'website' => $newData->website,
        'country_code' => $newData->country_code,
    ]);
});

test('can validate brand name is required', function (): void {
    Livewire::test(CreateBrand::class)
        ->fillForm([
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required']);
});

test('can validate brand website is valid url', function (): void {
    Livewire::test(CreateBrand::class)
        ->fillForm([
            'name' => 'Test Brand',
            'website' => 'not-a-valid-url',
        ])
        ->call('create')
        ->assertHasFormErrors(['website' => 'url']);
});

test('can render brand edit page', function (): void {
    $brand = Brand::factory()->create();

    Livewire::test(EditBrand::class, ['record' => $brand->getRouteKey()])
        ->assertOk();
});

test('can retrieve brand data for editing', function (): void {
    $brand = Brand::factory()->create();

    Livewire::test(EditBrand::class, ['record' => $brand->getRouteKey()])
        ->assertFormSet([
            'name' => $brand->name,
            'website' => $brand->website,
            'country_code' => $brand->country_code,
            'logo_path' => $brand->logo_path,
        ]);
});

test('can update brand', function (): void {
    $brand = Brand::factory()->create();
    $newData = Brand::factory()->make();

    Livewire::test(EditBrand::class, ['record' => $brand->getRouteKey()])
        ->fillForm([
            'name' => $newData->name,
            'website' => $newData->website,
            'country_code' => $newData->country_code,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $brand->refresh();

    expect($brand->name)->toBe($newData->name)
        ->and($brand->website)->toBe($newData->website)
        ->and($brand->country_code)->toBe($newData->country_code);
});

test('can validate brand name is required on edit', function (): void {
    $brand = Brand::factory()->create();

    Livewire::test(EditBrand::class, ['record' => $brand->getRouteKey()])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

test('can search brands by name', function (): void {
    $brands = Brand::factory()->count(10)->create();
    $firstBrand = $brands->first();

    Livewire::test(ListBrands::class)
        ->searchTable($firstBrand->name)
        ->assertCanSeeTableRecords($brands->where('name', $firstBrand->name))
        ->assertCanNotSeeTableRecords($brands->where('name', '!=', $firstBrand->name));
});

test('can search brands by website', function (): void {
    $brandWithWebsite = Brand::factory()->create(['website' => 'https://unique-test-site.com']);
    $otherBrands = Brand::factory()->count(5)->create();

    Livewire::test(ListBrands::class)
        ->searchTable('unique-test-site')
        ->assertCanSeeTableRecords([$brandWithWebsite])
        ->assertCanNotSeeTableRecords($otherBrands);
});

test('can bulk delete brands', function (): void {
    $brands = Brand::factory()->count(10)->create();

    Livewire::test(ListBrands::class)
        ->callTableBulkAction('delete', $brands);

    foreach ($brands as $brand) {
        $this->assertModelMissing($brand);
    }
});

test('can sort brands by name', function (): void {
    Brand::factory()->count(5)->create();

    Livewire::test(ListBrands::class)
        ->sortTable('name')
        ->assertSuccessful();
});

test('can accept valid country code from enum', function (): void {
    Livewire::test(CreateBrand::class)
        ->fillForm([
            'name' => 'Test Brand',
            'country_code' => 'US',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Brand::class, [
        'name' => 'Test Brand',
        'country_code' => 'US',
    ]);
});
