<?php

namespace App\Http\Controllers\Admins;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use App\Services\NotificationService;

class ReportController extends Controller
{
  public function __construct(private NotificationService $notification)
  {
    $this->authorizeResource(Report::class);
  }

  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $reports = Report::latest()->paginate(10);

    return view('admins.reports.index', [
      'reports' => $reports,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    return view('admins.reports.create');
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(ReportRequest $request)
  {
    $validated = $request->validated();

    Report::create($validated);

    return redirect()->route('admins.reports.index')
      ->with('success', 'Report created successfully');
  }

  /**
   * Display the specified resource.
   */
  public function show(Report $report)
  {
    return view('admins.reports.show', [
      'report' => $report,
    ]);
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Report $report)
  {
    return view('admins.reports.edit', [
      'report' => $report,
    ]);
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(ReportRequest $request, Report $report)
  {
    $validated = $request->validated();

    $report->update($validated);

    return redirect()->route('admins.reports.index')
      ->with('success', 'Report updated successfully');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Report $report)
  {
    $report->delete();

    return redirect()->route('admins.reports.index')
      ->with('success', 'Report deleted successfully');
  }
}
