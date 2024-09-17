        // Array of colors to apply to cards
        const colors = [
            '#FF6347', '#FF4500', '#FFD700', '#32CD32', '#00FA9A', 
            '#00BFFF', '#1E90FF', '#4682B4', '#6A5ACD', '#8A2BE2'
        ];

        function shuffleColors() {
            // Shuffle colors array
            const shuffledColors = colors.sort(() => Math.random() - 0.5);

            // Apply colors to cards
            document.querySelectorAll('.card').forEach((card, index) => {
                card.style.backgroundColor = shuffledColors[index % shuffledColors.length];
            });
        }

        // Initial shuffle
        shuffleColors();

        // Shuffle colors every 5 seconds
        setInterval(shuffleColors, 5000);
  