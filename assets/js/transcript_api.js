export function getTranscript(id) {

    console.log('fetching...');
    return fetch('/transcript/json/8', {
        credentials: 'same-origin'
    })
        .then(response => {
            return response.json();
        });
}


