<?php

namespace App\View\Components\Lecturer;

use Illuminate\View\Component;

class CardQuestionLecturer extends Component
{
    public $imageUrl, $questionSetName, $subjectName, $lecturerName;

    public function __construct($imageUrl, $questionSetName, $subjectName, $lecturerName)
    {
        $this->imageUrl = $imageUrl;
        $this->questionSetName = $questionSetName;
        $this->subjectName = $subjectName;
        $this->lecturerName = $lecturerName;
    }

    public function render()
    {
        return view('components.lecturer.card-question-lecturer');
    }
}
