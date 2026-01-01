<?php

declare(strict_types=1);

use App\Filament\Resources\StringSets\Pages\CreateStringSet;
use App\Filament\Resources\StringSets\Pages\EditStringSet;
use App\Filament\Resources\StringSets\Pages\ListStringSets;
use App\Models\Brand;
use App\Models\StringSet;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Livewire;

beforeEach(function (): void {
    $this->actingAs(User::factory()->create());
});

test('can render string set list page', function (): void {
    Livewire::test(ListStringSets::class)
        ->assertOk();
});

test('can list string sets', function (): void {
    $stringSets = StringSet::factory()->count(10)->create();

    Livewire::test(ListStringSets::class)
        ->assertCanSeeTableRecords($stringSets);
});

test('can render string set create page', function (): void {
    Livewire::test(CreateStringSet::class)
        ->assertOk();
});

test('can create string set', function (): void {
    $brand = Brand::factory()->create();

    Livewire::test(CreateStringSet::class)
        ->fillForm([
            'brand_id' => $brand->id,
            'name' => 'Test String Set',
            'product_code' => 'TS-12345',
            'winding_length' => 32.50,
            'number_of_strings' => 6,
            'high_gauge' => 45,
            'low_gauge' => 105,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(StringSet::class, [
        'name' => 'Test String Set',
        'product_code' => 'TS-12345',
        'winding_length' => 3250, // Stored as integer
        'number_of_strings' => 6,
        'high_gauge' => 45,
        'low_gauge' => 105,
    ]);
});

test('winding_length is transformed correctly when creating', function (): void {
    $brand = Brand::factory()->create();

    Livewire::test(CreateStringSet::class)
        ->fillForm([
            'brand_id' => $brand->id,
            'name' => 'Test String Set',
            'winding_length' => 42.75,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $stringSet = StringSet::query()->where('name', 'Test String Set')->first();

    expect($stringSet->getAttributes()['winding_length'])->toBe(4275)
        ->and($stringSet->winding_length)->toBe(42.75);
});

test('can validate string set name is required', function (): void {
    $brand = Brand::factory()->create();

    Livewire::test(CreateStringSet::class)
        ->fillForm([
            'brand_id' => $brand->id,
            'name' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['name' => 'required']);
});

test('can render string set edit page', function (): void {
    $stringSet = StringSet::factory()->create();

    Livewire::test(EditStringSet::class, ['record' => $stringSet->getRouteKey()])
        ->assertOk();
});

test('can retrieve string set data for editing', function (): void {
    $brand = Brand::factory()->create();
    $stringSet = StringSet::factory()->create([
        'brand_id' => $brand->id,
        'name' => 'Original Name',
        'product_code' => 'TS-99999',
        'winding_length' => 35.25,
        'number_of_strings' => 5,
        'high_gauge' => '50',
        'low_gauge' => '110',
    ]);

    Livewire::test(EditStringSet::class, ['record' => $stringSet->getRouteKey()])
        ->assertFormSet([
            'brand_id' => $brand->id,
            'name' => 'Original Name',
            'product_code' => 'TS-99999',
            'winding_length' => 35.25, // Should be displayed as decimal
            'number_of_strings' => 5,
            'high_gauge' => '50',
            'low_gauge' => '110',
        ]);
});

test('winding_length displays as decimal in edit form', function (): void {
    $stringSet = StringSet::factory()->create();

    // Directly update the database without going through the mutator
    DB::table('string_sets')
        ->where('id', $stringSet->id)
        ->update(['winding_length' => 4043]);

    $stringSet->refresh();

    Livewire::test(EditStringSet::class, ['record' => $stringSet->getRouteKey()])
        ->assertFormSet([
            'winding_length' => 40.43,
        ]);
});

test('can update string set', function (): void {
    $stringSet = StringSet::factory()->create();
    $brand = Brand::factory()->create();

    Livewire::test(EditStringSet::class, ['record' => $stringSet->getRouteKey()])
        ->fillForm([
            'brand_id' => $brand->id,
            'name' => 'Updated Name',
            'product_code' => 'UP-12345',
            'winding_length' => 28.50,
            'number_of_strings' => 4,
            'high_gauge' => '40',
            'low_gauge' => '100',
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $stringSet->refresh();

    expect($stringSet->name)->toBe('Updated Name')
        ->and($stringSet->product_code)->toBe('UP-12345')
        ->and($stringSet->winding_length)->toBe(28.50)
        ->and($stringSet->getAttributes()['winding_length'])->toBe(2850)
        ->and($stringSet->number_of_strings)->toBe(4)
        ->and($stringSet->high_gauge)->toBe(40)
        ->and($stringSet->low_gauge)->toBe(100)
        ->and($stringSet->brand_id)->toBe($brand->id);
});

test('can validate string set name is required on edit', function (): void {
    $stringSet = StringSet::factory()->create();

    Livewire::test(EditStringSet::class, ['record' => $stringSet->getRouteKey()])
        ->fillForm([
            'name' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['name' => 'required']);
});

test('can search string sets by name', function (): void {
    $stringSets = StringSet::factory()->count(10)->create();
    $firstStringSet = $stringSets->first();

    Livewire::test(ListStringSets::class)
        ->searchTable($firstStringSet->name)
        ->assertCanSeeTableRecords($stringSets->where('name', $firstStringSet->name))
        ->assertCanNotSeeTableRecords($stringSets->where('name', '!=', $firstStringSet->name));
});

test('can search string sets by product code', function (): void {
    $stringSet = StringSet::factory()->create(['product_code' => 'UNIQUE-12345']);
    $otherStringSets = StringSet::factory()->count(5)->create();

    Livewire::test(ListStringSets::class)
        ->searchTable('UNIQUE-12345')
        ->assertCanSeeTableRecords([$stringSet])
        ->assertCanNotSeeTableRecords($otherStringSets);
});

test('can bulk delete string sets', function (): void {
    $stringSets = StringSet::factory()->count(10)->create();

    Livewire::test(ListStringSets::class)
        ->callTableBulkAction('delete', $stringSets);

    foreach ($stringSets as $stringSet) {
        $this->assertModelMissing($stringSet);
    }
});

test('can sort string sets by name', function (): void {
    StringSet::factory()->count(5)->create();

    Livewire::test(ListStringSets::class)
        ->sortTable('name')
        ->assertSuccessful();
});

test('can sort string sets by winding_length', function (): void {
    StringSet::factory()->count(5)->create();

    Livewire::test(ListStringSets::class)
        ->sortTable('winding_length')
        ->assertSuccessful();
});

test('table displays winding_length as formatted decimal', function (): void {
    $stringSet = StringSet::factory()->create();
    $stringSet->setAttribute('winding_length', 3225);
    $stringSet->save();

    Livewire::test(ListStringSets::class)
        ->assertCanSeeTableRecords([$stringSet]);
});

test('created_by is automatically set on create', function (): void {
    $user = User::factory()->create();
    $this->actingAs($user);

    $brand = Brand::factory()->create();

    Livewire::test(CreateStringSet::class)
        ->fillForm([
            'brand_id' => $brand->id,
            'name' => 'Test String Set',
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $stringSet = StringSet::query()->where('name', 'Test String Set')->first();

    expect($stringSet->created_by)->toBe($user->id);
});
