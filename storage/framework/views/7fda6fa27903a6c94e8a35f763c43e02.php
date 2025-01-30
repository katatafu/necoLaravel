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
            background-color: #ffffff; /* White background for overlay */
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            z-index: 9999;
        }

        /* Spinner Styling */
        .loading-spinner {
            border: 4px solid #f3f3f3; /* Light gray */
            border-top: 4px solid #ff4747; /* Red */
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

        /* Photo Container Styling */
        .photo-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        /* Photo Styling */
        .photo-item {
            position: relative;
            background: #f8f8f8;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, filter 0.3s ease;
            opacity: 0.7;
            filter: grayscale(100%);
            cursor: pointer;
            transition: transform 0.3s ease, opacity 0.3s ease, filter 0.3s ease;
        }

        /* Photo Hover Effect */
        .photo-item:hover {
            transform: scale(1.05); /* Zoom in */
            filter: grayscale(0%); /* Restore colors */
            opacity: 1; /* Make the photo fully opaque */
        }

        /* Photo Image Styling */
        .photo-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: opacity 0.3s ease;
        }

        /* Hover Title Styling */
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

        /* Show title when hovered */
        .photo-item:hover h3 {
            opacity: 1;
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

    <!-- ✅ Portfolio Section -->
    <div class="container mx-auto mt-6 p-4">
        <h1 class="text-3xl font-bold text-center mb-6">My Portfolio</h1>

        <div class="photo-container" id="photo-container">
            <!-- Manually added image items for now -->
            <div class="photo-item">
                <img src="<?php echo e(asset('images/minecraft.png')); ?>" alt="Minecraft">
                <h3>Minecraft</h3>
            </div>

            <div class="photo-item">
                <img src="<?php echo e(asset('images/blender.png')); ?>" alt="Blender">
                <h3>Blender</h3>
            </div>

            <div class="photo-item">
                <img src="<?php echo e(asset('images/ninja.png')); ?>" alt="Ninja">
                <h3>Ninja</h3>
            </div>

            <div class="photo-item">
                <img src="<?php echo e(asset('images/soutez.png')); ?>" alt="Soutěž">
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

        // Search functionality
        document.getElementById("search").addEventListener("input", function(event) {
            const query = event.target.value.toLowerCase();

            document.querySelectorAll(".photo-item").forEach(photo => {
                const title = photo.getAttribute("data-title");
                if (title.includes(query)) {
                    photo.style.display = "block";
                } else {
                    photo.style.display = "none";
                }
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
    </script>

</body>
</html><?php /**PATH C:\Users\Aly\Documents\laravel-backend\resources\views/welcome.blade.php ENDPATH**/ ?>