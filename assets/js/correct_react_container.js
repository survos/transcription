import ReactDom from "react-dom";
import React from "react";
import CorrectApp from './CorrectApp';

let student = document.getElementById('starting_transcript').value;
let corrected = document.getElementById('correct_transcript').html;

ReactDom.render(
    <div>
        <CorrectApp student={student} corrected={corrected} />
    </div>,
    document.getElementById('correct-app')
);
