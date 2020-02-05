export function getTranscript(id) {

  console.log('fetching...');
  return fetch('/transcript/json/' + id, {
  credentials: 'same-origin'
})
.then(response => {
  return response.json();
});
}