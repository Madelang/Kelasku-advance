<?php

namespace App\Repositories;

use App\Models\School;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;

interface interfaceSchoolRepository
{
    public function showAll();
}


class SchoolRepository implements interfaceSchoolRepository
{
    public function showAll()
    {
        return School::all();
    }
    /**
     * Get data school with pagination
     */
    public function getSchools()
    {
        return School::paginate(10);
    }
    public function updateSchool($id, $data)
    {
        try {
            return School::findOrFail($id)->update($data);
        } catch (ModelNotFoundException $th) {
            throw $th;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteSchool($id)
    {
        try {
            $school = School::findOrFail($id);
            $school->delete();
            return $school;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function createSchool($data)
    {
        try {
            School::create($data);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
