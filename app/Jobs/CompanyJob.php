<?php

namespace App\Jobs;

use App\Models\Company;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CompanyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Company id
     *
     * @var int $id ;
     */
    private $id;

    /**
     * Create a new job instance.
     *
     * @param $id
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     * @throws Exception
     */
    public function handle()
    {
        $company = Company::where('id', $this->id)->first();

        if ($company) {
            $client = new Client();

            try {
                $response = $client->request('GET', $company->internet_address);
                $company->website_html = minifyHtml(addslashes(htmlspecialchars(utf8_encode($response->getBody()))));
                $company->save();
            } catch (GuzzleException $e) {
                $this->fail($e->getMessage());
            }
        }
    }
}
