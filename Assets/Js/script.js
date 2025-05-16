/**
 * Script principal pour l'application d'analyse de log
 * Mini-Projet PHP - Partie loueur et authentification
 */

document.addEventListener('DOMContentLoaded', function() {
    // Gestion des messages d'alerte
    const alerts = document.querySelectorAll('.alert');
    if (alerts.length > 0) {
        alerts.forEach(alert => {
            // Faire disparaître les messages d'alerte après 5 secondes
            setTimeout(() => {
                alert.style.transition = 'opacity 1s';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 1000);
            }, 5000);
        });
    }

    // Validation des formulaires
    const loginForm = document.getElementById('login-form');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                showErrorMessage('Veuillez remplir tous les champs');
            }
        });
    }

    // Fonction pour afficher des messages d'erreur
    function showErrorMessage(message) {
        const errorContainer = document.getElementById('error-container');
        if (errorContainer) {
            errorContainer.innerHTML = '';
            const alert = document.createElement('div');
            alert.className = 'alert alert-danger';
            alert.textContent = message;
            errorContainer.appendChild(alert);
        }
    }

    // Gestion des liens de pagination pour l'historique des statistiques
    const paginationLinks = document.querySelectorAll('.pagination-link');
    if (paginationLinks.length > 0) {
        paginationLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                const page = this.getAttribute('data-page');
                const urlParams = new URLSearchParams(window.location.search);
                urlParams.set('page', page);
                window.location.search = urlParams.toString();
                e.preventDefault();
            });
        });
    }

    // Initialisation des graphiques si la page contient des éléments graphiques
    initializeCharts();
});

/**
 * Initialise les graphiques de statistiques si présents sur la page
 */
function initializeCharts() {
    const chartContainers = document.querySelectorAll('[data-chart]');
    
    if (chartContainers.length === 0) return;
    
    chartContainers.forEach(container => {
        const chartType = container.getAttribute('data-chart');
        const chartData = JSON.parse(container.getAttribute('data-chart-data'));
        const chartLabels = JSON.parse(container.getAttribute('data-chart-labels'));
        
        // Si la bibliothèque Chart.js est chargée, on peut créer des graphiques
        if (typeof Chart !== 'undefined') {
            const ctx = container.getContext('2d');
            
            // Configuration de base pour les graphiques
            const config = {
                type: chartType,
                data: {
                    labels: chartLabels,
                    datasets: [{
                        label: 'Statistiques',
                        data: chartData,
                        backgroundColor: [
                            'rgba(231, 76, 60, 0.7)',   // Rouge pour les KO
                            'rgba(243, 156, 18, 0.7)',  // Orange pour les timeouts
                            'rgba(52, 152, 219, 0.7)'   // Bleu pour les totaux
                        ],
                        borderColor: [
                            'rgba(231, 76, 60, 1)',
                            'rgba(243, 156, 18, 1)',
                            'rgba(52, 152, 219, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            };
            
            // Création du graphique
            new Chart(ctx, config);
        }
    });
}