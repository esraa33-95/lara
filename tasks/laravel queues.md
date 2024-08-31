<h1>laravel queues</h1>
<p>Laravel allows you to easily create queued jobs that may be processed in the background.
 By moving time intensive tasks to a queue, your application can respond to web requests with blazing speed and provide a better user experience to your customers.</p>

 <p>Laravel queues provide a unified queueing API across a variety of different queue backends, such as Amazon SQS, Redis, or even a relational database.</p>

 -Laravel's queue configuration options are stored in your application's config/queue.php configuration file.

 -In your config/queue.php configuration file, there is a connections configuration array. This option defines the connections to backend queue services such as Amazon SQS, Beanstalk, or Redis.

 -if you dispatch a job without explicitly defining which queue it should be dispatched to, the job will be placed on the queue that is defined in the queue attribute of the connection configuration.

 use App\Jobs\ProcessPodcast;
 
// This job is sent to the default connection's default queue...
ProcessPodcast::dispatch();
 
// This job is sent to the default connection's "emails" queue...
ProcessPodcast::dispatch()->onQueue('emails');



<p>Some applications may not need to ever push jobs onto multiple queues, instead preferring to have one simple queue</p>


- Laravel queue worker allows you to specify which queues it should process by priority. For example, if you push jobs to a high queue, you may run a worker that gives them higher processing priority:

php artisan queue:work --queue=high,default


<h2>Driver Notes and Prerequisites</h2>
1.Database

-In order to use the database queue driver, you will need a database table to hold the jobs. Typically, this is included in Laravel's default

1.1Redis

-In order to use the redis queue driver, you should configure a Redis database connection in your config/database.php configuration file.

'redis' => [
    'driver' => 'redis',
    'connection' => env('REDIS_QUEUE_CONNECTION', 'default'),
    'queue' => env('REDIS_QUEUE', '{default}'),
    'retry_after' => env('REDIS_QUEUE_RETRY_AFTER', 90),
    'block_for' => null,
    'after_commit' => false,
],

1.2 Blocking

-you may use the block_for configuration option to specify how long the driver should wait for a job to become available before iterating through the worker loop and re-polling the Redis database.

- For instance, you may set the value to 5 to indicate that the driver should block for five seconds while waiting for a job to become available
'block_for' => 5,

<h3>Other Driver Prerequisites</h3>
-These dependencies may be installed via the Composer package manager.

-Amazon SQS: aws/aws-sdk-php ~3.0
-Beanstalkd: pda/pheanstalk ~5.0
-Redis: predis/predis ~2.0 or phpredis PHP extension

<h2>Creating Jobs</h2>
1.Generating Job Classes
By default, all of the queueable jobs for your application are stored in the app/Jobs directory. If the app/Jobs directory doesn't exist, it will be created when you run the make:job Artisan command:
-php artisan make:job ProcessPodcast

-The generated class will implement the Illuminate\Contracts\Queue\ShouldQueue interface, indicating to Laravel that the job should be pushed onto the queue to run asynchronously.

*Class Structure

-we'll pretend we manage a podcast publishing service and need to process the uploaded podcast files before they are published.

<?php
 
namespace App\Jobs;
 
use App\Models\Podcast;
use App\Services\AudioProcessor;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
 
class ProcessPodcast implements ShouldQueue
{
    use Queueable;
 
    /**
     * Create a new job instance.
     */
    public function __construct(
        public Podcast $podcast,
    ) {}
 
    /**
     * Execute the job.
     */
    public function handle(AudioProcessor $processor): void
    {
        // Process uploaded podcast...
    }
}

<h3>handle Method Dependency Injection</h3>

-The handle method is invoked when the job is processed by the queue. Note that we are able to type-hint dependencies on the handle method of the job.

-If you would like to take total control over how the container injects dependencies into the handle method, you may use the container's bindMethod method. The bindMethod method accepts a callback which receives the job and the container.

use App\Jobs\ProcessPodcast;
use App\Services\AudioProcessor;
use Illuminate\Contracts\Foundation\Application;
 
$this->app->bindMethod([ProcessPodcast::class, 'handle'], function (ProcessPodcast $job, Application $app) {
    return $job->handle($app->make(AudioProcessor::class));
});

<p>to prevent relations from being serialized, you can call the withoutRelations method on the model when setting a property value. This method will return an instance of the model without its loaded relationships:</p>

/**
 * Create a new job instance.
 */
public function __construct(Podcast $podcast)
{
    $this->podcast = $podcast->withoutRelations();
}

-jobs must be encrypted
<?php
 
use Illuminate\Contracts\Queue\ShouldBeEncrypted;
use Illuminate\Contracts\Queue\ShouldQueue;
 
class UpdateSearchIndex implements ShouldQueue, ShouldBeEncrypted
{
    // ...
}

-Preventing Job Overlaps

For example, let's imagine you have a queued job that updates a user's credit score and you want to prevent credit score update job overlaps for the same user ID. To accomplish this, you can return the WithoutOverlapping middleware from your job's middleware method:

use Illuminate\Queue\Middleware\WithoutOverlapping;
 
/**
 * Get the middleware the job should pass through.
 *
 * @return array<int, object>
 */
public function middleware(): array
{
    return [new WithoutOverlapping($this->user->id)];
}

- You may also specify the number of seconds that must elapse before the released job will be attempted again:
/**
 * Get the middleware the job should pass through.
 *
 * @return array<int, object>
 */
public function middleware(): array
{
    return [(new WithoutOverlapping($this->order->id))->releaseAfter(60)];
}

<h3>Sharing Lock Keys Across Job Classes</h3>
-By default, the WithoutOverlapping middleware will only prevent overlapping jobs of the same class. So, although two different job classes may use the same lock key.

<h3>Dispatching Jobs</h3>
<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Jobs\ProcessPodcast;
use App\Models\Podcast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
 
class PodcastController extends Controller
{
    /**
     * Store a new podcast.
     */
    public function store(Request $request): RedirectResponse
    {
        $podcast = Podcast::create(/* ... */);
 
        // ...
 
        ProcessPodcast::dispatch($podcast);
 
        return redirect('/podcasts');
    }
}

-If you would like to conditionally dispatch a job, you may use the dispatchIf and dispatchUnless methods:

<p>Delayed Dispatching</p>
-If you would like to specify that a job should not be immediately available for processing by a queue worker, you may use the delay method when dispatching the job. For example, let's specify that a job should not be available for processing until 10 minutes after it has been dispatched:

<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use App\Jobs\ProcessPodcast;
use App\Models\Podcast;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
 
class PodcastController extends Controller
{
    /**
     * Store a new podcast.
     */
    public function store(Request $request): RedirectResponse
    {
        $podcast = Podcast::create(/* ... */);
 
        // ...
 
        ProcessPodcast::dispatch($podcast)
                    ->delay(now()->addMinutes(10));
 
        return redirect('/podcasts');
    }
}

<h3>Dispatching After the Response is Sent to the Browser</h3>

-the dispatchAfterResponse method delays dispatching a job until after the HTTP response is sent to the user's browser if your web server is using FastCGI. This will still allow the user to begin using the application even though a queued job is still executing. This should typically only be used for jobs that take about a second, such as sending an email.

use App\Jobs\SendNotification;
 
SendNotification::dispatchAfterResponse();

<h3>Synchronous Dispatching</h3>

-If you would like to dispatch a job immediately (synchronously), you may use the dispatchSync method. When using this method, the job will not be queued and will be executed immediately within the current process:

<h3>Job Chaining</h3>
-Job chaining allows you to specify a list of queued jobs that should be run in sequence after the primary job has executed successfully. If one job in the sequence fails, the rest of the jobs will not be run. To execute a queued job chain, you may use the chain method provided by the Bus facade.

use App\Jobs\OptimizePodcast;
use App\Jobs\ProcessPodcast;
use App\Jobs\ReleasePodcast;
use Illuminate\Support\Facades\Bus;
 
Bus::chain([
    new ProcessPodcast,
    new OptimizePodcast,
    new ReleasePodcast,
])->dispatch();

-Adding Jobs to the Chain
-Occasionally, you may need to prepend or append a job to an existing job chain from within another job in that chain. You may accomplish this using the prependToChain and appendToChain methods:
/**
 * Execute the job.
 */
public function handle(): void
{
    // ...
 
    // Prepend to the current chain, run job immediately after current job...
    $this->prependToChain(new TranscribePodcast);
 
    // Append to the current chain, run job at end of chain...
    $this->appendToChain(new TranscribePodcast);
}



<h3>Job Batching</h3>

-Laravel's job batching feature allows you to easily execute a batch of jobs and then perform some action when the batch of jobs has completed executing.

-This migration may be generated using the make:queue-batches-table Artisan command

php artisan make:queue-batches-table
 
php artisan migrate

<p>Dispatching Batches</p>
-To dispatch a batch of jobs, you should use the batch method of the Bus facade. Of course, batching is primarily useful when combined with completion callbacks. So, you may use the then, catch, and finally methods to define completion callbacks for the batch. 

-Dispatching Batches
To dispatch a batch of jobs, you should use the batch method of the Bus facade. Of course, batching is primarily useful when combined with completion callbacks. So, you may use the then, catch, and finally methods to define completion callbacks for the batch. 

use App\Jobs\ImportCsv;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
use Throwable;
 
$batch = Bus::batch([
    new ImportCsv(1, 100),
    new ImportCsv(101, 200),
    new ImportCsv(201, 300),
    new ImportCsv(301, 400),
    new ImportCsv(401, 500),
])->before(function (Batch $batch) {
    // The batch has been created but no jobs have been added...
})->progress(function (Batch $batch) {
    // A single job has completed successfully...
})->then(function (Batch $batch) {
    // All jobs completed successfully...
})->catch(function (Batch $batch, Throwable $e) {
    // First batch job failure detected...
})->finally(function (Batch $batch) {
    // The batch has finished executing...
})->dispatch();
 
return $batch->id;

-Chains and Batches
For example, we may execute two job chains in parallel and execute a callback when both job chains have finished processing

use App\Jobs\ReleasePodcast;
use App\Jobs\SendPodcastReleaseNotification;
use Illuminate\Bus\Batch;
use Illuminate\Support\Facades\Bus;
 
Bus::batch([
    [
        new ReleasePodcast(1),
        new SendPodcastReleaseNotification(1),
    ],
    [
        new ReleasePodcast(2),
        new SendPodcastReleaseNotification(2),
    ],
])->then(function (Batch $batch) {
    // ...
})->dispatch();


-Adding Jobs to Batches
$batch = Bus::batch([
    new LoadImportBatch,
    new LoadImportBatch,
    new LoadImportBatch,
])->then(function (Batch $batch) {
    // All jobs completed successfully...
})->name('Import Contacts')->dispatch();

-Inspecting Batches

-The Illuminate\Bus\Batch instance that is provided to batch completion callbacks has a variety of properties and methods to assist you in interacting with and inspecting a given batch of jobs:

// The UUID of the batch...
$batch->id;
 
// The name of the batch (if applicable)...
$batch->name;
 
// The number of jobs assigned to the batch...
$batch->totalJobs;
 
// The number of jobs that have not been processed by the queue...
$batch->pendingJobs;
 
// The number of jobs that have failed...
$batch->failedJobs;
 
// The number of jobs that have been processed thus far...
$batch->processedJobs();
 
// The completion percentage of the batch (0-100)...
$batch->progress();
 
// Indicates if the batch has finished executing...
$batch->finished();
 
// Cancel the execution of the batch...
$batch->cancel();
 
// Indicates if the batch has been cancelled...
$batch->cancelled();

-Returning Batches From Routes
To retrieve a batch by its ID, you may use the Bus facade's findBatch method:
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Route;
 
Route::get('/batch/{batchId}', function (string $batchId) {
    return Bus::findBatch($batchId);
});

-Cancelling Batches
/**
 * Execute the job.
 */
public function handle(): void
{
    if ($this->user->exceedsImportLimit()) {
        return $this->batch()->cancel();
    }
 
    if ($this->batch()->cancelled()) {
        return;
    }
}

Batch Failures

When a batched job fails, the catch callback (if assigned) will be invoked. This callback is only invoked for the first job that fails within the batch.

-Batch Failures
-When a batched job fails, the catch callback (if assigned) will be invoked. This callback is only invoked for the first job that fails within the batch.

$batch = Bus::batch([
    // ...
])->then(function (Batch $batch) {
    // All jobs completed successfully...
})->allowFailures()->dispatch();


-Pruning Batches
-Without pruning, the job_batches table can accumulate records very quickly. To mitigate this, you should schedule the queue:prune-batches Artisan command to run daily:

use Illuminate\Support\Facades\Schedule;
 
Schedule::command('queue:prune-batches')->daily();

-DynamoDB Configuration
 install the AWS SDK so that your Laravel application can communicate with Amazon DynamoDB:

 composer require aws/aws-sdk-php

 -Queueing Closures
-Instead of dispatching a job class to the queue, you may also dispatch a closure. This is great for quick, simple tasks that need to be executed outside of the current request cycle.


$podcast = App\Podcast::find(1);
 
dispatch(function () use ($podcast) {
    $podcast->publish();
});


Running the Queue Worker
-The queue:work Command
php artisan queue:work


 -you may run the queue:listen command.
  -When using the queue:listen command, you don't have to manually restart the worker when you want to reload your updated code or reset the application state.

  php artisan queue:listen

  -Processing a Specified Number of Jobs
-The --once option may be used to instruct the worker to only process a single job from the queue:
php artisan queue:work --once


-The --max-jobs option may be used to instruct the worker to process the given number of jobs and then exit.
php artisan queue:work --max-jobs=1000

-Queue Priorities
-Sometimes you may wish to prioritize how your queues are processed. For example, in your config/queue.php configuration file, you may set the default queue for your redis connection to low. However, occasionally you may wish to push a job to a high priority queue like so:

dispatch((new Job)->onQueue('high'));


Queue Workers and Deployment
 -the simplest way to deploy an application using queue workers is to restart the workers during your deployment process. You may gracefully restart all of the workers by issuing the queue:restart command:

 php artisan queue:restart


 -Job Expirations and Timeouts
-Worker Timeouts

queue:work Artisan command exposes a --timeout option.
- By default, the --timeout value is 60 seconds. If a job is processing for longer than the number of seconds specified by the timeout value, the worker processing the job will exit with an error. Typically, the worker will be restarted automatically by a process manager configured on your server:

php artisan queue:work --timeout=60

*Supervisor Configuration
-In production, you need a way to keep your queue:work processes running. A queue:work process may stop running for a variety of reasons, such as an exceeded worker timeout or the execution of the queue:restart command.

sudo apt-get install supervisor

Starting Supervisor

sudo supervisorctl reread
 
sudo supervisorctl update
 
sudo supervisorctl start "laravel-worker:*"

-Retrying Failed Jobs
To view all of the failed jobs that have been inserted into your failed_jobs database table, you may use the queue:failed Artisan command:
php artisan queue:failed

-to retry a failed job that has an ID of ce7bb17c-cdd8-41f0-a8ec-7b4fef4e5ece, issue the following command:
php artisan queue:retry ce7bb17c-cdd8-41f0-a8ec-7b4fef4e5ece

-If necessary, you may pass multiple IDs to the command:
php artisan queue:retry ce7bb17c-cdd8-41f0-a8ec-7b4fef4e5ece 91401d2c-0784-4f43-824c-34f94a33c24d

-You may also retry all of the failed jobs for a particular queue:
php artisan queue:retry --queue=name


-To retry all of your failed jobs, execute the queue:retry command and pass all as the ID:
php artisan queue:retry all


-To delete all of your failed jobs from the failed_jobs table, you may use the queue:flush command:
php artisan queue:flush


<h3>Clearing Jobs From Queues</h3>
-If you would like to delete all jobs from the default queue of the default connection, you may do so using the queue:clear Artisan command:

php artisan queue:clear

-You may also provide the connection argument and queue option to delete jobs from a specific connection and queue:

php artisan queue:clear redis --queue=emails

<h3>Monitoring Your Queues</h3>
-If your queue receives a sudden influx of jobs, it could become overwhelmed, leading to a long wait time for jobs to complete. If you wish, Laravel can alert you when your queue job count exceeds a specified threshold.

To get started, you should schedule the queue:monitor command to run every minute. The command accepts the names of the queues you wish to monitor as well as your desired job count threshold:

php artisan queue:monitor redis:default,redis:deployments --max=100

<h3>Testing</h3>
-When testing code that dispatches jobs, you may wish to instruct Laravel to not actually execute the job itself, since the job's code can be tested directly and separately of the code that dispatches it. Of course, to test the job itself, you may instantiate a job instance and invoke the handle method directly in your test.

-You may use the Queue facade's fake method to prevent queued jobs from actually being pushed to the queue. After calling the Queue facade's fake method, you may then assert that the application attempted to push jobs to the queue:

<?php
 
use App\Jobs\AnotherJob;
use App\Jobs\FinalJob;
use App\Jobs\ShipOrder;
use Illuminate\Support\Facades\Queue;
 
test('orders can be shipped', function () {
    Queue::fake();
 
    // Perform order shipping...
 
    // Assert that no jobs were pushed...
    Queue::assertNothingPushed();
 
    // Assert a job was pushed to a given queue...
    Queue::assertPushedOn('queue-name', ShipOrder::class);
 
    // Assert a job was pushed twice...
    Queue::assertPushed(ShipOrder::class, 2);
 
    // Assert a job was not pushed...
    Queue::assertNotPushed(AnotherJob::class);
 
    // Assert that a Closure was pushed to the queue...
    Queue::assertClosurePushed();
 
    // Assert the total number of jobs that were pushed...
    Queue::assertCount(3);
});

-Faking a Subset of Jobs
-You may fake all jobs except for a set of specified jobs using the except method:

Queue::fake()->except([
    ShipOrder::class,
]);


-Testing Job Chains
-To test job chains, you will need to utilize the Bus facade's faking capabilities. The Bus facade's assertChained method may be used to assert that a chain of jobs was dispatched.

use App\Jobs\RecordShipment;
use App\Jobs\ShipOrder;
use App\Jobs\UpdateInventory;
use Illuminate\Support\Facades\Bus;
 
Bus::fake();
 
// ...
 
Bus::assertChained([
    ShipOrder::class,
    RecordShipment::class,
    UpdateInventory::class
]);


-Testing Job Batches
-The Bus facade's assertBatched method may be used to assert that a batch of jobs was dispatched. The closure given to the assertBatched method receives an instance of Illuminate\Bus\PendingBatch, which may be used to inspect the jobs within the batch:

use Illuminate\Bus\PendingBatch;
use Illuminate\Support\Facades\Bus;
 
Bus::fake();
 
// ...
 
Bus::assertBatched(function (PendingBatch $batch) {
    return $batch->name == 'import-csv' &&
           $batch->jobs->count() === 10;
});

<p>Testing Job / Queue Interactions</p>
- you may need to test that the job deleted itself. You may test these queue interactions by instantiating the job and invoking the withFakeQueueInteractions method.

use App\Jobs\ProcessPodcast;
 
$job = (new ProcessPodcast)->withFakeQueueInteractions();
 
$job->handle();
 
$job->assertReleased(delay: 30);
$job->assertDeleted();
$job->assertNotDeleted();
$job->assertFailed();
$job->assertNotFailed();

<p> Job Events </p>
-Using the before and after methods on the Queue facade, you may specify callbacks to be executed before or after a queued job is processed. These callbacks are a great opportunity to perform additional logging or increment statistics for a dashboard. Typically, you should call these methods from the boot method of a service provider. 

<?php
 
namespace App\Providers;
 
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // ...
    }
 
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Queue::before(function (JobProcessing $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });
 
        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });
    }
}


-Using the looping method on the Queue facade, you may specify callbacks that execute before the worker attempts to fetch a job from a queue.

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Queue;
 
Queue::looping(function () {
    while (DB::transactionLevel() > 0) {
        DB::rollBack();
    }
});





















































































































































































































