<?php

namespace App\Jobs;

use App\Services\Quidkey\Traits\BackwardDispatchable;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Osiset\ShopifyApp\Contracts\ShopModel as IShopModel;

class AfterAuthenticateJob implements ShouldQueue
{
    use BackwardDispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * The shop domain.
     *
     * @var IShopModel
     */
    protected IShopModel $shop;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(IShopModel $shop)
    {
        $this->shop = $shop;
    }

    /**
     * Execute the job.
     *
     * @throws Exception
     */
    public function handle(): bool
    {
        return true;
    }
}
