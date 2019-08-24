import ReactDom from "react-dom";
import React from "react";
import CorrectApp from './CorrectApp';
import CorrectTranscript from './CorrectTranscript';

let transcriptId = document.getElementById('transcript_id').html;

ReactDom.render(
    <div>
        <CorrectTranscript id={transcriptId} isLoaded={false} />
    </div>,
    document.getElementById('correct-app')
);
