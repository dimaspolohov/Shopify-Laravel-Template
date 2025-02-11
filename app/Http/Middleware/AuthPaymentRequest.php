<?php

namespace App\Http\Middleware;

use Exception;
use Osiset\BasicShopifyAPI\BasicShopifyAPI;
use Osiset\BasicShopifyAPI\Options;
use Osiset\BasicShopifyAPI\Traits\IsRequestType;
use Psr\Http\Message\RequestInterface;
use Osiset\BasicShopifyAPI\Middleware\AbstractMiddleware;

/**
 * Ensures we have the proper request for private and public calls.
 * Also modifies issues with redirects.
 */
class AuthPaymentRequest extends AuthRequest
{
    /**
     * Versions the API call with the set version.
     *
     * @param string $uri The request URI.
     *
     * @return string
     */
    protected function versionPath(string $uri): string
    {
        $version = $this->api->getOptions()->getVersion();
        if ($version === null ||
            preg_match(Options::VERSION_PATTERN, $uri) ||
            !$this->isAuthableRequest($uri) ||
            !$this->isVersionableRequest($uri)
        ) {
            // No version set, or already versioned... nothing to do
            return $uri;
        }

        // Graph request
        if ($this->isGraphRequest($uri)) {
            return str_replace('/admin/api', "/payments_apps/api/{$version}", $uri);
        }

        // REST request
        return preg_replace('/\/admin(\/api)?\//', "/payments_apps/api/{$version}/", $uri);
    }
}
