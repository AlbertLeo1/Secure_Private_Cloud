<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix'=>'emr', 'as'=>'api.emr.'], function () {
    Route::get('/appointments/initials', 'AppointmentController@initials')->name('appointments.initials');

    Route::apiResources([
        'appointments' => 'AppointmentController',
        'patients'     => 'PatientController',
        'payments'     => 'PaymentController',
    ]);
});

Route::group(['prefix'=>'emr/assessments', 'as'=>'api.emr.assessments.'], function () {
    Route::get('/assess/assigned',        'Assessment\MainController@assessment')->name('assigned');
    Route::get('/assess/dom_assigned',    'Assessment\MainController@dom_assessment')->name('dom_assigned');

    Route::apiResources([
        '/assess'             => 'Assessment\MainController',
        '/types'              => 'Assessment\TypeController',
    ]);
});

Route::group(['prefix'=>'emr/domiciliary', 'as'=>'api.emr.domiciliary.'], function () {
    Route::put('/requests/assign/{id}',         'Domiciliary\RequestController@assign')->name('requests.assign');
    Route::put('/requests/confirm/{id}',        'Domiciliary\RequestController@confirm')->name('requests.confirm');
    Route::get('/requests/pending',             'Domiciliary\RequestController@pending')->name('requests.pending');
    Route::get('/batch_assigns/assigned',       'Domiciliary\BatchAssignController@assigned')->name('batch_assign.assigned');
    Route::put('/batch_assigns/confirm/{id}',   'Domiciliary\BatchAssignController@confirmArrival')->name('batch_assign.confirm-arrival');
    Route::post('/batch_assigns/search',        'Domiciliary\BatchAssignController@search')->name('batch_assign.search');
    Route::get('/assessments/assigned',         'Domiciliary\RequestController@assessment')->name('assessments.assigned');

    Route::apiResources([
        'batch_assigns'     => 'Domiciliary\BatchAssignController',
        'batch_tasks'       => 'Domiciliary\BatchController',
        'requests'          => 'Domiciliary\RequestController',
        'shift_types'       => 'Domiciliary\ShiftTypeController',
    ]);
});

Route::group(['prefix'=>'emr/hims', 'as'=>'api.emr.hims.'], function () {
    Route::get('/drugs/search',              'Hims\DrugController@search')->name('drugs.search');
    Route::get('/prescriptions/initials',    'Hims\PrescriptionController@initials')->name('prescriptions.initials');

    Route::apiResources([
        'allergies'     => 'Hims\AllergyController',
        'allergy_types' => 'Hims\AllergyTypeController',
        'contacts'      => 'Hims\ContactController',
        'drugs'         => 'Hims\DrugController',
        'patients'      => 'Hims\PatientController',
        'prescriptions' => 'Hims\PrescriptionController',
        'vitals'        => 'Hims\VitalController',
    ]);
});

Route::group(['prefix'=>'emr/nursing', 'as'=>'api.emr.nursing.'], function () {
    Route::get('/patient_tasks/dom/{id}',      'Nursing\PatientTaskController@domiciliary')->name('patient_tasks.domiciliary');
    Route::get('/tasks/initials',              'Nursing\TaskController@initials')->name('tasks.initials');
    
    Route::apiResources([
        'patient_tasks'  => 'Nursing\PatientTaskController',
        'tasks'          => 'Nursing\TaskController',
    ]);
});