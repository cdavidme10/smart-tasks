<?php

namespace App\Observers;

use App\Managers\AuthManager;
use App\Models\User;

class UserObserver
{
    public function __construct(
        protected readonly AuthManager $authManager
    ) {}

    public function created(User $user): void
    {
        $this->authManager->checkMilestone();
    }
}
