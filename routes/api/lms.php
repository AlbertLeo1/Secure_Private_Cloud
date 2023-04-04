<?php 
use Illuminate\Support\Facades\Route;

Route::group(['prefix'=>'lms'], function () {
    
    Route::get('/std_courses/initialize/{id}', 'StdCourseController@initialize')->name('std_courses.initialize');
    Route::get('/std_lessons/complete/{id}', 'StdLessonController@complete')->name('std_lessons.complete');
    Route::get('/assign_tutors', 'AssignUserController@tutors');
    Route::post('/assign_tutors', 'AssignUserController@tutor_assign');
    Route::post('/lessons/fileUpload', 'LessonController@fileUpload')->name('lesson.fileUpload');
    Route::post('/lessons/modify', 'LessonController@modify')->name('lesson.modify');
    Route::post('/course/assign_tutors', 'CourseController@assign_tutors')->name('course.assign_tutors');
    Route::post('/course/assign_users', 'CourseController@assign_users')->name('course.assign_users');
    
    Route::apiResources([
        '/assign_users' => 'AssignUserController',
        '/categories' => 'CategoryController',
        '/courses' => 'CourseController',
        '/departments' => 'DepartmentController',
        '/exams' => 'ExamController',
        '/exam_results' => 'ExamResultController',
        '/exam_types' => 'ExamTypeController',
        '/lessons' => 'LessonController',
        '/options' => 'OptionController',
        '/questions' => 'QuestionController',
        '/sub_categories' => 'SubCategoryController',
        '/std_courses' => 'StdCourseController',
        '/std_exams' => 'StdExamController',
        '/std_lessons' => 'StdLessonController',
        '/tut_courses' => 'TutCourseController',
        '/tut_exams' => 'TutExamController',
    ]);
});