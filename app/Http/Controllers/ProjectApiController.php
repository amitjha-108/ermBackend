<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

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

    public function getProjects()
    {
        $projects = Project::all();

        return response()->json(['message' => 'Projects Retrieved Successfully!', 'projects' => $projects], 200);
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
}
