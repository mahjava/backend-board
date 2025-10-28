<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        // Projects
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });

        // Statuses
        Schema::create('statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['Todo', 'InProgress', 'Done'])->default('Todo');
            $table->unsignedInteger('order_index')->default(0);
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });

        // Project Status (Pivot)
        Schema::create('project_status', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('cascade');
            $table->boolean('is_active')->default(true);

            $table->primary(['project_id', 'status_id']);
        });

        // Workflow Transitions
        Schema::create('workflow_transitions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('from_status_id')->constrained('statuses')->onDelete('cascade');
            $table->foreignId('to_status_id')->constrained('statuses')->onDelete('cascade');
            $table->timestamps();
        });

        // Issues
        Schema::create('issues', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();

            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('reporter_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('assignee_id')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('status_id')->constrained('statuses')->onDelete('restrict');

            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Medium');
            $table->enum('type', ['Bug', 'Task', 'Story'])->default('Task');

            $table->timestamps();
        });

        // Comments
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issue_id')->constrained('issues')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->text('content');
            $table->timestamps();
        });

        // Sprints
        Schema::create('sprints', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
        });

        // Issue - Sprint (Pivot)
        Schema::create('issue_sprint', function (Blueprint $table) {
            $table->foreignId('issue_id')->constrained('issues')->onDelete('cascade');
            $table->foreignId('sprint_id')->constrained('sprints')->onDelete('cascade');

            $table->primary(['issue_id', 'sprint_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('issue_sprint');
        Schema::dropIfExists('sprints');
        Schema::dropIfExists('comments');
        Schema::dropIfExists('issues');
        Schema::dropIfExists('workflow_transitions');
        Schema::dropIfExists('project_status');
        Schema::dropIfExists('statuses');
        Schema::dropIfExists('projects');
    }
};
