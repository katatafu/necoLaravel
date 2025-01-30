<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios@0.21.1/dist/axios.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Loading Spinner and Overlay Styling */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
        }

        /* Spinner Styling */
        .loading-spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #ff4747;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
        }

        /* Animation for spinner */
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Main Layout Styling */
        .container {
            display: flex;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 20px;
            position: relative;
        }

        .photo-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Two equal-width columns layout */
            gap: 15px;
            width: 75%;
            transition: transform 1s ease;
        }

        /* Filter Sidebar Styling */
        .filter-sidebar {
            position: absolute;
            top: 80px;
            right: 10px;
            width: 250px;
            background-color: #f8f8f8;
            padding: 20px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            margin-top: 20px;
        }

        /* Title of filter, centered text */
        .filter-title {
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin-bottom: 20px;
        }

        /* Dropdown menu styles */
        .dropdown {
            width: 100%;
            padding: 10px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            cursor: pointer;
            text-align: center; /* Center text */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
            z-index: 1;
            text-align: center;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            color: black;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        /* Photo Item Styling */
        .photo-item {
            position: relative;
            background: #f8f8f8;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            opacity: 0.7;
            filter: grayscale(100%);
            transition: transform 0.3s ease, filter 0.3s ease;
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.3s ease, filter 0.3s ease;
        }

        .photo-item:hover {
            transform: scale(1.05);
            filter: grayscale(0%);
            opacity: 1;
        }

        /* All images are forced to be squares */
        .photo-item img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Ensures all images fit in the grid cells */
            aspect-ratio: 1 / 1; /* Force the images into a square */
            transition: opacity 0.3s ease;
        }

        .photo-item h3 {
            padding: 15px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            font-size: 18px;
            position: absolute;
            bottom: 0;
            width: 100%;
            text-align: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .photo-item:hover h3 {
            opacity: 1;
        }

        /* Ninja Image Customization (crop to head part) */
        .ninja img {
            object-position: top; /* This makes sure the top part of the image is shown */
        }

        /* Navbar Styling */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar img {
            height: 40px;
        }

        /* Search Bar Styling */
        .search-bar {
            padding: 10px;
            width: 250px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

    </style>
</head>
<body class="bg-gray-100">

    <!-- ✅ Loading Overlay (white screen with spinner and logo) -->
    <div class="loading-overlay" id="loading-overlay">
        <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" alt="Laravel Logo" class="mb-4" width="80">
        <div class="loading-spinner"></div>
        <p id="loading-text" class="mt-4 text-gray-800 text-xl font-semibold">Loading...</p>
    </div>

    <!-- ✅ Navbar -->
    <nav class="navbar">
        <a href="/">
            <img src="https://upload.wikimedia.org/wikipedia/commons/9/9a/Laravel.svg" class="h-8 w-8 mr-2" alt="Laravel Logo">
        </a>
        <!-- Search Bar -->
        <input type="text" id="search" placeholder="Search photos..." class="search-bar">
    </nav>

    <!-- ✅ Filter Sidebar Under Navbar -->
    <div class="filter-sidebar">
        <div class="filter-title">Filter By</div>

        <!-- Filter by All -->
        <button class="dropdown" onclick="filterAll()">All</button>

        <!-- Filter by Date -->
        <div class="dropdown">
            Date
            <div class="dropdown-content">
                <a href="#" onclick="filterByDate('latest')">Newest</a>
                <a href="#" onclick="filterByDate('oldest')">Oldest</a>
            </div>
        </div>

        <!-- Filter by Custom Date -->
        <div class="dropdown">
            Custom Date
            <div class="dropdown-content">
                <a href="#" onclick="filterByCustomDate('2023-03-15')">March 15, 2023</a>
                <a href="#" onclick="filterByCustomDate('2022-11-22')">November 22, 2022</a>
                <a href="#" onclick="filterByCustomDate('2024-01-09')">January 9, 2024</a>
            </div>
        </div>
    </div>

    <!-- ✅ Main Container -->
    <div class="container">

        <!-- Photo Gallery -->
        <div class="photo-container" id="photo-container">
            <!-- Example Images -->
            <div class="photo-item" data-title="Minecraft" data-date="2023-03-15">
                <img src="{{ asset('images/minecraft.png') }}" alt="Minecraft">
                <h3>Minecraft</h3>
            </div>

            <div class="photo-item" data-title="Blender" data-date="2022-11-22">
                <img src="{{ asset('images/blender.png') }}" alt="Blender">
                <h3>Blender</h3>
            </div>

            <div class="photo-item ninja" data-title="Ninja" data-date="2024-01-09">
                <img src="{{ asset('images/ninja.png') }}" alt="Ninja">
                <h3>Ninja</h3>
            </div>

            <div class="photo-item" data-title="Soutez" data-date="2023-07-20">
                <img src="{{ asset('images/soutez.png') }}" alt="Soutěž">
                <h3>Soutěž</h3>
            </div>
        </div>
    </div>

    <script>
        // GSAP animation for loading photos
        gsap.from(".photo-item", {
            opacity: 0,
            y: 50,
            stagger: 0.3,
            duration: 1
        });

        // Photo hover animation with GSAP
        document.querySelectorAll('.photo-item').forEach(item => {
            item.addEventListener('mouseenter', () => {
                gsap.to(item, { scale: 1.1, duration: 0.5 });
            });
            item.addEventListener('mouseleave', () => {
                gsap.to(item, { scale: 1, duration: 0.5 });
            });
        });

        // Hide loading overlay after page loads (with minimum duration of 3 seconds)
        window.addEventListener("load", () => {
            setTimeout(() => {
                // Change text after loading is done
                document.getElementById("loading-text").textContent = "Loaded!";
                gsap.to("#loading-overlay", {
                    opacity: 0,
                    duration: 1,
                    onComplete: () => {
                        document.getElementById("loading-overlay").style.display = "none";
                    }
                });
            }, 3000); // Wait for 3 seconds before hiding the overlay and changing text
        });

        // Filter functionality
        function filterByDate(date) {
            const photos = document.querySelectorAll(".photo-item");
            photos.forEach(photo => {
                const photoDate = new Date(photo.getAttribute('data-date'));
                if (date === 'latest' && photoDate > new Date()) {
                    photo.style.display = 'block';
                } else if (date === 'oldest' && photoDate < new Date()) {
                    photo.style.display = 'block';
                } else {
                    photo.style.display = 'none';
                }
            });
        }

        function filterAll() {
            const photos = document.querySelectorAll(".photo-item");
            photos.forEach(photo => {
                photo.style.display = 'block';
            });
        }

        function filterByCustomDate(date) {
            const photos = document.querySelectorAll(".photo-item");
            photos.forEach(photo => {
                if (photo.getAttribute('data-date') === date) {
                    photo.style.display = 'block';
                } else {
                    photo.style.display = 'none';
                }
            });
        }
    </script>

</body>
</html>
