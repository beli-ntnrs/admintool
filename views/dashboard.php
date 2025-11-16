<?php
// Load shared navigation
require_once __DIR__ . '/../../internal-shared/components/nav.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notioneers Admintool</title>
    <link href="/css/theme.css" rel="stylesheet">
</head>
<body>
    <?php renderInternalNav('Admintool'); ?>

    <div class="container-fluid py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Header -->
                <div class="mb-5">
                    <h1 class="mb-2">Notioneers Admintool</h1>
                    <p class="lead text-stone">Central dashboard for all internal applications and tools.</p>
                </div>

                <!-- Quick Stats -->
                <div class="row g-4 mb-5">
                    <div class="col-md-3">
                        <div class="card bg-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-stone small mb-1">Internal Apps</p>
                                        <h3 class="mb-0">2</h3>
                                    </div>
                                    <div class="text-bloom">
                                        <svg width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                                            <path d="M5.255 5.786a.237.237 0 0 0 .241.247h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286zm1.557 5.763c0 .533.425.927 1.01.927.609 0 1.028-.394 1.028-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-stone small mb-1">Public Apps</p>
                                        <h3 class="mb-0">0</h3>
                                    </div>
                                    <div class="text-aeris">
                                        <svg width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-stone small mb-1">Components</p>
                                        <h3 class="mb-0">12+</h3>
                                    </div>
                                    <div class="text-muse">
                                        <svg width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-white border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="text-stone small mb-1">Status</p>
                                        <h3 class="mb-0 text-success">Active</h3>
                                    </div>
                                    <div class="text-success">
                                        <svg width="40" height="40" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Internal Apps -->
                <div class="mb-5">
                    <h2 class="mb-4">Internal Applications</h2>
                    <div class="row g-4">
                        <!-- Design System -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="p-2 bg-mist rounded me-3">
                                            <svg width="32" height="32" fill="#063312" viewBox="0 0 16 16">
                                                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2zm5.5 10a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Design System</h5>
                                            <small class="text-stone">Component Library</small>
                                        </div>
                                    </div>
                                    <p class="text-stone small">
                                        Browse all available UI components, colors, typography, and design patterns.
                                    </p>
                                    <a href="http://localhost:8001" class="btn btn-dark-green btn-sm w-100" target="_blank">
                                        Open App
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Placeholder for future apps -->
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm bg-veil">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="p-2 bg-white rounded me-3">
                                            <svg width="32" height="32" fill="#7B847B" viewBox="0 0 16 16">
                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <h5 class="mb-0 text-stone">Add New App</h5>
                                            <small class="text-stone">Coming soon</small>
                                        </div>
                                    </div>
                                    <p class="text-stone small">
                                        Create a new internal application using the app template.
                                    </p>
                                    <button class="btn btn-grey btn-sm w-100" disabled>
                                        Coming Soon
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="mb-5">
                    <h2 class="mb-4">Quick Links</h2>
                    <div class="card bg-white border-0 shadow-sm">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <a href="https://github.com/beli-ntnrs/design-system" target="_blank" class="text-decoration-none">
                                        <div class="d-flex align-items-center">
                                            <div class="text-depth me-3">
                                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="fw-medium text-depth">GitHub Repository</div>
                                                <small class="text-stone">Design System</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="https://notioneers.eu/en/ai-style-guide" target="_blank" class="text-decoration-none">
                                        <div class="d-flex align-items-center">
                                            <div class="text-depth me-3">
                                                <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                                    <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1v-1z"/>
                                                    <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5h3zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="fw-medium text-depth">AI Style Guide</div>
                                                <small class="text-stone">Brand Guidelines</small>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex align-items-center text-stone">
                                        <div class="me-3">
                                            <svg width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M11 6.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z"/>
                                                <path d="M2.5 0A1.5 1.5 0 0 0 1 1.5v13A1.5 1.5 0 0 0 2.5 16h11a1.5 1.5 0 0 0 1.5-1.5v-13A1.5 1.5 0 0 0 13.5 0h-11zM2 1.5a.5.5 0 0 1 .5-.5h11a.5.5 0 0 1 .5.5V15H2V1.5z"/>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="fw-medium">Documentation</div>
                                            <small>Coming Soon</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-lift {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.15) !important;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
