<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Osiset\ShopifyApp\Util;

/**
 * Rewrite original method to fix request variable name
 */
class VerifyShopify extends \Osiset\ShopifyApp\Http\Middleware\VerifyShopify
{
    /**
     * Get the token from request (if available).
     *
     * @param  Request  $request  The request object.
     *
     * @return string|null
     */
    protected function getAccessTokenFromRequest(Request $request): ?string
    {
        $token = !empty($request->get('id_token')) ? $request->get('id_token') : $request->get('token');
        if (Util::getShopifyConfig('turbo_enabled')) {
            if ($request->bearerToken()) {
                // Bearer tokens collect.
                // Turbo does not refresh the page, values are attached to the same header.
                $bearerTokens = Collection::make(explode(',', $request->header('Authorization', '')));
                return Str::substr(trim($bearerTokens->last()), 7);
            }

            return $token;
        }

        return $this->isApiRequest($request) ? $request->bearerToken() : $token;
    }
}
