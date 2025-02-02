<?php



namespace App\Console\Commands;



use Illuminate\Console\Command;

use Spatie\Permission\Models\Permission;

use Spatie\Permission\Models\Role;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str; // Import the Str class

class CreatePermission extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'permission:module {module}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create permissions for a given module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $moduleName = $this->argument('module');

        // Convert module name to snake_case
        $moduleName = Str::snake($moduleName, '-');

        // Permissions list
        $permissions = [
            'create-' . $moduleName,
            'view-' . $moduleName,
            'update-' . $moduleName,
            'delete-' . $moduleName,
            'self-' . $moduleName,
        ];

        foreach ($permissions as $permission) {
            // Check if permission already exists, if not, create it
            if (!Permission::where('name', $permission)->exists()) {
                Permission::create(['name' => $permission]);
                $this->info("$permission permission is created");
            } else {
                $this->info("$permission permission already exists");
            }
        }

        // Give these permissions to SuperAdmin
        $role = Role::findByName('SuperAdmin');
        $role->syncPermissions(Permission::all());

        $this->info("SuperAdmin role synced with new permissions.");
    }

}

