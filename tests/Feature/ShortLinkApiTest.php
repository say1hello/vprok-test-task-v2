<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ShortLink;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShortLinkApiTest extends TestCase
{
//    use RefreshDatabase;

    public function test_get_short_link_ok()
    {
        $link = 'https://www.google.com';
        $response = $this->postJson('/api/short-link', ['link' => $link]);
        $shortLink = ShortLink::where('link', $link)->first();

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => route('shorten.link', $shortLink->code),
            ]);
    }

    public function test_get_short_link_invalid_url()
    {
        $response = $this->postJson('/api/short-link', ['link' => 'google.com']);

        $response
            ->assertStatus(422)
            ->assertJson([
                "message" => "The given data was invalid.",
                "errors" => [
                    "link" => [
                        "The link format is invalid."
                    ]
                ]
            ]);
    }

    public function test_get_original_link_ok()
    {
        $link = 'https://www.google.com';
        $shortLink = ShortLink::where('link', $link)->first();
        if (!$shortLink) {
            $shortLink = ShortLink::create([
                'link' => $link,
                'code' => ShortLink::generateUniqueID(),
            ]);
        }

        $response = $this->getJson("/api/short-link/{$shortLink->code}");

        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => $link,
            ]);
    }

    public function test_get_original_link_not_found()
    {
        $response = $this->getJson('/api/short-link/123');

        $response->assertStatus(404);
    }
}
