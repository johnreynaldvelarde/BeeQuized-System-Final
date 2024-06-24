<footer>

</footer>    
</body>
     <!-- Important -->
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/jquery/jquery-3.7.1.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/bootstrap/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/popper.min.js"></script>
    <script type="text/javascript" src="<?=ASSETS?>quizbee/scripts/socket/socket.io.js"></script>
    
<script>
    
    function fetchLeaderboard() {
        const xhr = new XMLHttpRequest();
        xhr.open('GET', window.location.href + '?action=get_leaderboard', true);
        xhr.onload = function() {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.error) {
                    //displayErrorMessage(response.error); // Handle error message if any
                } else {
                    display_leaderboard(response); // Call function to display leaderboard
                }
            } else {
                console.error('Request failed with status:', xhr.status);
            }
        };

        xhr.onerror = function() {
            console.error('Request failed');
        };

        xhr.send();
    }


    function display_leaderboard(leaderboard) {
    const leaderboardContainer = document.querySelector('.leaderboard-placeholder'); // Adjust this selector as needed
    if (!leaderboard || leaderboard.length === 0) {
        // No team participants yet
        leaderboardContainer.innerHTML = '<p class="text-white text-center">Waiting for team participants</p>';
    } else {
        // Display leaderboard table
        let leaderboardHtml = `
            <div class="container mx-auto p-4 flex flex-col min-h-screen">
                <div class="flex-grow flex flex-col items-center justify-center">
                    <div class="w-full max-w-4xl relative">
                        <div class="flex justify-center mb-8 mt-8 relative z-10">`;

        

        // Display top 2 (left side)
        if (leaderboard.length >= 2) {
            leaderboardHtml += `
                <!-- Top 2 (left side) -->
                <div class="flex flex-col items-center mx-4" style="margin-left: -60px;">
                    <div class="w-32 h-32 bg-gray-300 rounded-full flex items-center justify-center mb-2 relative">
                        <img src="<?= ASSETS ?>quizbee/images/score_icon.png" alt="${leaderboard[1].team_name}" class="w-28 h-28 rounded-full">
                        <div class="absolute top-0 right-0 bg-red-500 text-white font-semibold rounded-full w-10 h-10 flex items-center justify-center">2nd</div>
                    </div>
                    <div class="text-lg font-semibold uppercase text-white">${leaderboard[1].team_name}</div>
                    <div class="text-lg font-semibold text-white">${leaderboard[1].total_score}</div>
                </div>`;
        }

        // Display top 1 (centered and higher)
        leaderboardHtml += `
            <!-- Top 1 -->
            <div class="flex flex-col items-center mx-4 relative" style="top: -100px;">
                <div class="w-48 h-48 bg-yellow-300 rounded-full flex items-center justify-center mb-2 relative">
                    <img src="<?= ASSETS ?>quizbee/images/score_icon.png" alt="${leaderboard[0].team_name}" class="w-40 h-40 rounded-full">
                    <div class="absolute top-0 right-0 bg-red-500 text-white font-semibold rounded-full w-12 h-12 flex items-center justify-center">1st</div>
                </div>
                <div class="text-xl font-semibold uppercase text-white">${leaderboard[0].team_name}</div>    
                <div class="text-xl font-semibold text-white">${leaderboard[0].total_score}</div>
            </div>`;

        // Display top 3 (right side)
        if (leaderboard.length >= 3) {
            leaderboardHtml += `
                <!-- Top 3 (right side) -->
                <div class="flex flex-col items-center mx-4" style="margin-right: -60px;">
                    <div class="w-32 h-32 bg-gray-300 rounded-full flex items-center justify-center mb-2 relative">
                        <img src="<?= ASSETS ?>quizbee/images/score_icon.png" alt="${leaderboard[2].team_name}" class="w-28 h-28 rounded-full">
                        <div class="absolute top-0 right-0 bg-red-500 text-white font-semibold rounded-full w-10 h-10 flex items-center justify-center">3rd</div>
                    </div>
                    <div class="text-lg font-semibold uppercase text-white">${leaderboard[2].team_name}</div>
                    <div class="text-lg font-semibold text-white">${leaderboard[2].total_score}</div>
                </div>`;
        }

        leaderboardHtml += `
                        </div>
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <div class="p-4">
                                <table class="min-w-full leading-normal mt-4">
                                    <thead>
                                        <tr>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Rank
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Team Name
                                            </th>
                                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                Overall Score
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>`;

        // Display the rest of the teams with their ranks and scores
        for (let i = 3; i < leaderboard.length; i++) {
            leaderboardHtml += `
                <tr>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">${i + 1}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">${leaderboard[i].team_name}</p>
                    </td>
                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                        <p class="text-gray-900 whitespace-no-wrap">${leaderboard[i].total_score}</p>
                    </td>
                </tr>`;
        }

        leaderboardHtml += `
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>`;

        leaderboardContainer.innerHTML = leaderboardHtml;
    }
}



    

    
    fetchLeaderboard();

</script>
</html>