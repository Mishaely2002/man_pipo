<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mwansele - Professional Contacts</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #7fa8e7ff 0%, #e4e8f0 100%);
            min-height: 100vh;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        .contact-icon {
            transition: all 0.3s ease;
        }
        
        .contact-icon:hover {
            transform: scale(1.1);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4 md:p-8">
    <div class="max-w-4xl w-full bg-white rounded-xl shadow-lg overflow-hidden">
        <!-- Header Section -->
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-6 md:p-8 text-white">
            <div class="flex flex-col md:flex-row items-center">
                <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-white shadow-lg mb-4 md:mb-0 md:mr-8">
                    <img src="https://placehold.co/400x400" alt="Mwansele professional portrait" class="w-full h-full object-cover">
                </div>
                <div class="text-center md:text-left">
                    <h1 class="text-2xl md:text-3xl font-bold">Mwansele</h1>
                    <p class="text-blue-100 mt-2 text-lg md:text-xl">Senior Software Engineer & Consultant</p>
                    <div class="flex justify-center md:justify-start space-x-4 mt-4">
                        <a href="#" class="text-white hover:text-blue-200 transition-colors">
                            <i class="fab fa-linkedin-in text-2xl"></i>
                        </a>
                        <a href="#" class="text-white hover:text-blue-200 transition-colors">
                            <i class="fab fa-github text-2xl"></i>
                        </a>
                        <a href="#" class="text-white hover:text-blue-200 transition-colors">
                            <i class="fab fa-twitter text-2xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-6 md:p-8">
            <!-- Contact Information -->
            <div class="bg-gray-50 rounded-lg p-6 shadow-sm transition-all duration-300 card-hover">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-address-card text-blue-600 mr-2 contact-icon"></i>
                    Contact Information
                </h2>
                
                <div class="space-y-4">
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-2 rounded-full mr-4">
                            <i class="fas fa-phone text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Phone</p>
                            <p class="text-gray-800 font-medium">+255 123 456 789</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-2 rounded-full mr-4">
                            <i class="fas fa-envelope text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Email</p>
                            <p class="text-gray-800 font-medium">contact@mwansele.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-2 rounded-full mr-4">
                            <i class="fas fa-map-marker-alt text-blue-600"></i>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm">Location</p>
                            <p class="text-gray-800 font-medium">Dar es Salaam, Tanzania</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start">
                        <div class="bg-blue-100 p-2 rounded-full mr-4">
                            <i class="fas fa-globe text-blue-600"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Availability -->
            <div class="bg-gray-50 rounded-lg p-6 shadow-sm transition-all duration-300 card-hover">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-calendar-check text-blue-600 mr-2 contact-icon"></i>
                    Availability
                </h2>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center mb-2">
                            <div class="w-3 h-3 rounded-full bg-green-500 mr-2"></div>
                            <p class="text-gray-800 font-medium">Available for consulting projects</p>
                        </div>
                        <p class="text-gray-600 text-sm">Flexible hours, remote or on-site</p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-gray-700 mb-3">Preferred contact method:</p>
                        <div class="flex space-x-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">Email</span>
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">WhatsApp</span>
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm">Zoom</span>
                        </div>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-gray-700 mb-2">Response time:</p>
                        <div class="relative pt-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-semibold text-gray-600">
                                    1-2 business days
                                </span>
                                <span class="text-xs font-semibold text-gray-600">
                                    100%
                                </span>
                            </div>
                            <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                                <div style="width:100%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Professional Summary -->
            <div class="md:col-span-2 bg-gray-50 rounded-lg p-6 shadow-sm transition-all duration-300 card-hover">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-user-tie text-blue-600 mr-2 contact-icon"></i>
                    Professional Overview
                </h2>
                
                <div class="prose max-w-none text-gray-700">
                    <p>Experienced software engineer specializing in web application development with expertise in PHP frameworks (Yii2, Laravel), JavaScript, and database systems.</p>
                    
                    <p class="mt-3">Offering:</p>
                    <ul class="list-disc pl-5 space-y-1">
                        <li>Custom software development</li>
                        <li>System architecture consulting</li>
                        <li>Technical mentorship</li>
                        <li>Project management</li>
                        <li>Code reviews and optimization</li>
                    </ul>
                    
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-100">
                        <p class="font-medium text-blue-800 mb-2"><i class="fas fa-info-circle mr-2"></i>Current Focus:</p>
                        <p>Helping educational institutions implement modern school management systems and digital transformation solutions.</p>
                    </div>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="md:col-span-2 bg-white rounded-lg p-6 shadow border border-gray-200 transition-all duration-300 card-hover">
                <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-paper-plane text-blue-600 mr-2 contact-icon"></i>
                    Quick Contact Form
                </h2>
                
                <form class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Your Name</label>
                        <input type="text" id="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="John Doe">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input type="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="you@example.com">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <input type="text" id="subject" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Inquiry about a project">
                    </div>
                    
                    <div class="md:col-span-2">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 transition" placeholder="Your message here..."></textarea>
                    </div>
                    
                    <div class="md:col-span-2">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg transition-colors flex items-center space-x-2">
                            <i class="fas fa-paper-plane"></i>
                            <span>Send Message</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="bg-gray-100 p-4 text-center border-t border-gray-200">
            <p class="text-gray-600 text-sm">
                &copy; 2025 Mwansele. All rights reserved.
                <span class="mx-2">|</span>
            </p>
        </div>
    </div>

    <script>
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    window.scrollTo({
                        top: target.offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Form submission handler
        const contactForm = document.querySelector('form');
        if (contactForm) {
            contactForm.addEventListener('submit', function(e) {
                e.preventDefault();
                alert('Thank you for your message! I will respond within 1-3 business days.');
                this.reset();
            });
        }
    </script>
</body>
</html>
