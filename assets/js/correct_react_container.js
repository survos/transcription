import ReactDom from "react-dom";
import React from "react";
import CorrectApp from './CorrectApp';
import CorrectTranscript from './CorrectTranscript';

let transcriptId = document.getElementById('info').dataset.transcriptId;
let paragraphNumber = document.getElementById('info').dataset.paragraphNumber;

ReactDom.render(
    <div>
        <CorrectTranscript id={parseInt(transcriptId)} paragraphNumber={parseInt(paragraphNumber)} isLoaded={false} />
    </div>,
    document.getElementById('correct-app')
);
