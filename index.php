<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bootstrap Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <div class="wrapper">
        <?php include "sidebar.php";?>
        <div class="main">
            <?php include "navbar.php";?>
            <main class="content px-3 py-2">
                <?php include "dashboard.php";?>
                <!-- Table Element -->
                <?php
                    $page = isset($_GET['page']) ? $_GET['page'] : 'songs';
                    if($page == 'songs'){
                        
                    }
                    if(!file_exists($page.".php")){
                        include '404.html';
                    }else{
                    include $page.'.php';
                    }
                ?>
        </div>
        </main>
        <!-- <a href="#" class="theme-toggle">
            <i class="fa-regular fa-moon"></i>
            <i class="fa-regular fa-sun"></i>
        </a> -->
        <?php include "footer.php";?>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
    <script>
    document.getElementById('search-input').addEventListener('input', function() {
        let query = this.value.trim();
        if (query.length > 0) {
            fetch(`search.php?query=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        displayResults(data.data.results);
                    } else {
                        document.getElementById('results').innerHTML = `<p>No results found</p>`;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('results').innerHTML = `<p>Error fetching results</p>`;
                });
        } else {
            document.getElementById('results').innerHTML = '';
        }
    });

    function displayResults(results) {
        let resultsContainer = document.getElementById('results');
        resultsContainer.innerHTML = '';
        let id = 1;
        results.forEach(song => {
            let songDiv = document.createElement('tr');
            songDiv.classList.add('results');
            songDiv.innerHTML = `
                                    <th scope="row">` + id + `</th>
                                    <td><img src="${song.image[1].url}" alt="${song.name}"></td>
                                    <td><b>${song.name}</b></td>
                                    <td><b>${song.language}</b></td>
                                    <td><b>${song.artists.primary[0].name}</b></td>
                                    <td><a href="${song.downloadUrl[4].url}" class="download-link">
                    <svg viewBox="0 0 256 256" height="32" width="38" xmlns="http://www.w3.org/2000/svg">
                        <path d="M74.34 85.66a8 8 0 0 1 11.32-11.32L120 108.69V24a8 8 0 0 1 16 0v84.69l34.34-34.35a8 8 0 0 1 11.32 11.32l-48 48a8 8 0 0 1-11.32 0ZM240 136v64a16 16 0 0 1-16 16H32a16 16 0 0 1-16-16v-64a16 16 0 0 1 16-16h52.4a4 4 0 0 1 2.83 1.17L111 145a24 24 0 0 0 34 0l23.8-23.8a4 4 0 0 1 2.8-1.2H224a16 16 0 0 1 16 16m-40 32a12 12 0 1 0-12 12a12 12 0 0 0 12-12" fill="currentColor"></path>
                    </svg>
                </a></td>
                `;
            id = id + 1;
            resultsContainer.appendChild(songDiv);
        });

        document.querySelectorAll('.download-link').forEach(link => {
            link.addEventListener('click', function(event) {
                event.preventDefault();
                const url = this.href;
                fetch(url)
                    .then(response => response.blob())
                    .then(blob => {
                        const blobUrl = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = blobUrl;
                        a.download = 'downloaded_file'; // Set the default download name
                        document.body.appendChild(a);
                        a.click();
                        a.remove();
                    })
                    .catch(console.error);
            });
        });
    }
    </script>
</body>

</html>