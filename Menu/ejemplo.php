<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Intercalar Secciones con un Botón</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        
        .container {
            width: 100%;
            max-width: 800px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        header {
            text-align: center;
            padding: 25px 20px;
            background: #2c3e50;
            color: white;
        }
        
        h1 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }
        
        .description {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .controls {
            display: flex;
            justify-content: center;
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
        }
        
        .toggle-btn {
            padding: 12px 35px;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background: #3498db;
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .toggle-btn:hover {
            background: #2980b9;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
        
        .toggle-btn:active {
            transform: translateY(0);
        }
        
        .sections-container {
            position: relative;
            min-height: 400px;
        }
        
        .section {
            padding: 30px;
            transition: all 0.5s ease;
        }
        
        .section-a {
            background: linear-gradient(135deg, #ffeaa7 0%, #fab1a0 100%);
        }
        
        .section-b {
            background: linear-gradient(135deg, #81ecec 0%, #74b9ff 100%);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            transform: translateX(100%);
            opacity: 0;
        }
        
        .section.active {
            transform: translateX(0);
            opacity: 1;
        }
        
        .section.hidden {
            transform: translateX(-100%);
            opacity: 0;
        }
        
        h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            color: #2c3e50;
            text-align: center;
        }
        
        p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 15px;
            text-align: justify;
        }
        
        .content {
            display: flex;
            gap: 20px;
            margin-top: 20px;
            align-items: center;
        }
        
        .content img {
            width: 150px;
            height: 150px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            object-fit: cover;
        }
        
        footer {
            text-align: center;
            padding: 20px;
            background: #2c3e50;
            color: white;
            font-size: 0.9rem;
        }
        
        @media (max-width: 768px) {
            .content {
                flex-direction: column;
                text-align: center;
            }
            
            .content img {
                width: 120px;
                height: 120px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
            
            h2 {
                font-size: 1.5rem;
            }
            
            .toggle-btn {
                padding: 10px 25px;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>Intercalar Secciones con un Botón</h1>
            <p class="description">Haz clic en el botón para alternar entre las dos secciones</p>
        </header>
        
        <div class="controls">
            <button class="toggle-btn" id="toggleButton1">
                <span>Mostrar Sección B</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        
        <div class="sections-container">
            <!-- Sección A -->
            <section class="section section-a active" id="sectionA">
                <h2>Sección A</h2>
                <p>Esta es la primera sección con un fondo cálido. Contiene información sobre temas generales y características principales.</p>
                <p>Puedes agregar aquí cualquier tipo de contenido: texto, imágenes, formularios, etc.</p>
                
                <div class="content">
                    <img src="https://images.unsplash.com/photo-1559028012-481c04fa702d?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Imagen decorativa">
                    <div>
                        <p>Las secciones intercaladas son útiles para:</p>
                        <ul>
                            <li>Mostrar contenido alternativo</li>
                            <li>Comparar información</li>
                            <li>Ahorrar espacio en pantalla</li>
                            <li>Mejorar la experiencia de usuario</li>
                        </ul>
                    </div>
                </div>
            </section>
            
            <!-- Sección B -->
            <section class="section section-b" id="sectionB">
                <h2>Sección B</h2>
                <p>Esta es la segunda sección con un fondo frío. Aquí puedes colocar contenido complementario o información adicional.</p>
                <p>Al intercalar secciones, creas un diseño visualmente atractivo que mantiene el interés del usuario.</p>
                
                <div class="content">
                    <div>
                        <p>Ventajas de intercalar secciones:</p>
                        <ul>
                            <li>Interfaz más dinámica</li>
                            <li>Navegación intuitiva</li>
                            <li>Mejor organización del contenido</li>
                            <li>Mayor engagement</li>
                        </ul>
                    </div>
                    <img src="https://images.unsplash.com/photo-1563089145-599997674d42?ixlib=rb-1.2.1&auto=format&fit=crop&w=500&q=80" alt="Imagen decorativa">
                </div>
            </section>
        </div>
        
        <footer>
            <p>© 2023 - Diseño de secciones intercaladas con un solo botón</p>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleButton = document.getElementById('toggleButton1');
            const buttonText = toggleButton.querySelector('span');
            const buttonIcon = toggleButton.querySelector('svg');
            const sectionA = document.getElementById('sectionA');
            const sectionB = document.getElementById('sectionB');
            
            let isSectionAVisible = true;
            
            // Función para alternar entre secciones
            toggleButton.addEventListener('click', function() {
                if (isSectionAVisible) {
                    // Mostrar sección B
                    sectionA.classList.remove('active');
                    sectionA.classList.add('hidden');
                    sectionB.classList.remove('hidden');
                    sectionB.classList.add('active');
                    buttonText.textContent = 'Mostrar Sección A';
                    // Rotar icono
                    buttonIcon.style.transform = 'rotate(180deg)';
                } else {
                    // Mostrar sección A
                    sectionB.classList.remove('active');
                    sectionB.classList.add('hidden');
                    sectionA.classList.remove('hidden');
                    sectionA.classList.add('active');
                    buttonText.textContent = 'Mostrar Sección B';
                    // Restaurar icono
                    buttonIcon.style.transform = 'rotate(0deg)';
                }
                
                // Cambiar el estado
                isSectionAVisible = !isSectionAVisible;
            });
        });
    </script>
</body>
</html>