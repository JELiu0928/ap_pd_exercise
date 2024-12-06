<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateCmsApi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:api {file : Api Class & fileName} {--f= : category by folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create CmsApi Template';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fileName = $this->argument('file');
        $fileFolder = empty($this->option('f')) ? '' : '/' . $this->option('f');

        if (preg_match('/[^A-Za-z0-9\_]+/', $fileName)) {
            $this->error('file name not allowed!');
            return Command::FAILURE;
        }

        if (!is_dir(app_path('Cms'))) {
            mkdir(app_path('Cms'));
        }

        if (!is_dir(app_path('Cms/Api'))) {
            mkdir(app_path('Cms/Api'));
        }

        if (!is_dir(app_path('Cms/Api' . $fileFolder))) {
            mkdir(app_path('Cms/Api' . $fileFolder));
        }

        if (is_file(app_path('Cms/Api' . $fileFolder . '/' . $fileName . '.php'))) {
            $this->error(app_path('Cms/Api' . $fileFolder . '/' . $fileName . '.php') . ' file already exist!');
            return Command::FAILURE;
        }

        $file = fopen(app_path('Cms/Api' . $fileFolder . '/' . $fileName . '.php'), 'wb');
        $content = $this->fileContent($fileName, preg_replace('/\//', '\\', $fileFolder));
        fwrite($file, $content);
        fclose($file);

        $this->info(app_path('Cms/Api' . $fileFolder . '/' . $fileName . '.php') . ' file created!');
        return Command::SUCCESS;
    }

    private function fileContent($fileName, $fileFolder)
    {
        return "<?php
namespace App\Cms\Api{$fileFolder};

use App\Services\Cms\agGrid\ColumnSet;
use App\Services\Cms\api\method\GetTable;
use App\Services\Cms\api\\response\TableResponse;
use App\Services\Cms\api\\traits\BasicRole;
use App\Services\Cms\api\\traits\BasicSql;
use App\Services\Cms\classes\CmsApi;
use Illuminate\Database\Eloquent\Builder;

class {$fileName} extends CmsApi implements GetTable
{
    use BasicRole, BasicSql;

    protected \$modelArray = [
        // modelName => modelClass
    ];
    protected \$copyArray = [
        // modelName => [ childModelName => foreignKey ]
    ];

    /** format when update, create, copy */
    protected function formatBuilder(string \$modelClass, Builder \$builder): Builder
    {
        if (\$modelClass === Model::class) {
            // do something...
        }

        if(\$modelClass === 'editContent') {
            // do something...
        }

        return \$builder;
    }

    public function getTable(): TableResponse
    {
        \$data = \$this->formatBuilder(Model::class, \$this->basicSql(Model::class))->get();
        \$colSet = ColumnSet::make();
        \$role = \$this->basicRole(false);
        return TableResponse::create(\$colSet, 'Model', \$data, \$this->cmsMenu, \$role);
    }

    /** whether api handle the Request */
    final public function check(): bool
    {
        return true;
    }
}";
    }
}
