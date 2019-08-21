let Diff = require('diff');
let $ = require('jquery');

var one = 'beep boop',
    other = 'beep boob blah',
    color = '',
    span = null;

let correct = $('#correct_transcript').html();
let student  = $('#student_transcript').html();

console.log(correct, student);

var diff = Diff.diffChars(correct, student),
    display = document.getElementById('display'),
    fragment = document.createDocumentFragment();

diff.forEach(function(part){
    // green for additions, red for deletions
    // grey for common parts
    color = part.added ? 'green' :
        part.removed ? 'red' : 'grey';
    span = document.createElement('span');
    span.style.color = color;
    span.appendChild(document
        .createTextNode(part.value));
    fragment.appendChild(span);
});

display.appendChild(fragment);
