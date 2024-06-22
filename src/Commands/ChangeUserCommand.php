<?php

namespace Rmsramos\ChangeUser\Commands;

use Illuminate\Console\Command;

class ChangeUserCommand extends Command
{
    public $signature = 'change-user';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
