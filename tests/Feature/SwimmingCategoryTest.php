<?php

namespace Tests\Feature\Livewire;

use App\Livewire\Category\SwimmingCategory;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SwimmingCategoryTest extends TestCase
{
    use RefreshDatabase;

public function component_can_render()
{
    $this->get('/swimming-category')
        ->assertStatus(200);
}

    /** @test */
    public function it_can_paginate_categories()
    {
        Category::factory()->count(15)->create();

        Livewire::test(SwimmingCategory::class)
            ->assertViewHas('swimmingCategory', function ($categories) {
                return $categories->count() === 10; // default paginate(10)
            });
    }

    /** @test */
    public function it_dispatches_refresh_input_event()
    {
        Livewire::test(SwimmingCategory::class)
            ->call('refreshInput')
            ->assertDispatched('refreshInput');
    }

    /** @test */
    public function it_dispatches_edit_event()
    {
        $category = Category::factory()->create();

        Livewire::test(SwimmingCategory::class)
            ->call('edit', $category->id)
            ->assertDispatched('editModal', $category->id);
    }

    /** @test */
    public function it_dispatches_delete_event()
    {
        $category = Category::factory()->create();

        Livewire::test(SwimmingCategory::class)
            ->call('delete', $category->id)
            ->assertDispatched('deleteModal', $category->id);
    }
}
