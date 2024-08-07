<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\AssignedTask;

class ProjectApiController extends Controller
{
    public function addProject(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'client' => 'nullable|string',
            'location' => 'nullable|string',
            'startDate' => 'nullable|string',
            'endDate' => 'nullable|string',
            'status' => 'nullable|string',
            'projectType' => 'nullable|string',
            'projectDescription' => 'nullable|string',
            'projectCost' => 'nullable|string',
            'developmentArea' => 'nullable|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $project = Project::create([
            'name' => $request->name,
            'client' => $request->client,
            'location' => $request->location,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
            'status' => $request->status,
            'projectType' => $request->projectType,
            'projectDescription' => $request->projectDescription,
            'projectCost' => $request->projectCost,
            'developmentArea' => $request->developmentArea,
        ]);

        return response()->json(['message' => 'Project Added Successfully!', 'project' => $project], 201);
    }

    public function updateProject(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string',
            'client' => 'nullable|string',
            'location' => 'nullable|string',
            'startDate' => 'nullable|string',
            'endDate' => 'nullable|string',
            'status' => 'nullable|string',
            'projectType' => 'nullable|string',
            'projectDescription' => 'nullable|string',
            'projectCost' => 'nullable|string',
            'developmentArea' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        $project->update($request->only([
            'name',
            'client',
            'location',
            'startDate',
            'endDate',
            'status',
            'projectType',
            'projectDescription',
            'projectCost',
            'developmentArea',
        ]));

        return response()->json(['message' => 'Project updated successfully!', 'project' => $project], 200);
    }

    public function getProjects()
    {
        $projects = Project::all();

        return response()->json(['message' => 'Projects Retrieved Successfully!', 'projects' => $projects], 200);
    }

    public function getProjectById($id)
    {
        $project = Project::find($id);

        if (!$project) {
            return response()->json(['error' => 'Project not found.'], 404);
        }

        return response()->json(['project' => $project], 200);
    }


    public function deleteProject($id)
    {
        $project = Project::find($id);

        if (! $project) {
            return response()->json(['error' => 'Project not found'], 404);
        }
        $project->delete();

        return response()->json(['message' => 'Project deleted successfully!'], 200);
    }

    public function createTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'project_id' => 'required|exists:projects,id',
            'empId' => 'required|exists:users,id',
            'taskDescription' => 'required|string',
            'priority' => 'required|string',
            'deadline' => 'required|date',
            'startTime' => 'nullable|date_format:H:i',
            'endTime' => 'nullable|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $task = AssignedTask::create([
            'project_id' => $request->project_id,
            'empId' => $request->empId,
            'taskDescription' => $request->taskDescription,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
            'assignedBy' => auth()->user()->id,
            'status' => '0',
            'startTime' => $request->startTime,
            'endTime' => $request->endTime,
        ]);

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }

    public function listAllTasks()
    {
        $tasks = AssignedTask::with([
            'employee:id,name,contact',
            'assignedByUser:id,name',
            'project:id,name'
        ])->get();
        return response()->json(['tasks' => $tasks], 200);
    }

    public function listOwnTasks(Request $request)
    {
        $tasks = AssignedTask::with([
            'employee:id,name,contact',
            'assignedByUser:id,name',
            'project:id,name'
        ])
        ->where('empId', $request->user()->id)
        ->get();

        return response()->json(['tasks' => $tasks], 200);
    }
}
