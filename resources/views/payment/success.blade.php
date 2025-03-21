<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
</head>
<body>
    <h1>Payment Successful!</h1>
    <p>Your download will start automatically. If it doesn't, click <a href="{{ route('pdf.download') }}">here</a> to download.</p>

    <script>
         window.onload = function() {

             // Create an invisible iframe
             var iframe = document.createElement('iframe');
             iframe.style.display = 'none';

             // Construct the URL for the download route
             var downloadUrl = '/download?filepath=' + encodeURIComponent('{{ $filePath }}') + '&filename=' + encodeURIComponent('{{ $fileName }}');

             // Set the iframe's source to the download URL
             iframe.src = downloadUrl;

             // Append the iframe to the body
             document.body.appendChild(iframe);
          }
     </script>
</body>
</html>