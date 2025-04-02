document.addEventListener('DOMContentLoaded', () => {
    // Insert or update player into active_players table when the page loads
    fetch('insert_player.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'action=insert'
    }).then(response => response.text())
      .then(data => console.log(data))  // Log the response for debugging
      .catch(error => console.error('Error:', error));

    // Update last_active every 3 seconds
    setInterval(() => {
        fetch('update_last_active.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=update'
        }).catch(error => console.error('Error:', error));
    }, 3000);

    // Remove player from active_players table when the page is closed or refreshed
    window.addEventListener('beforeunload', () => {
        navigator.sendBeacon('remove_player.php', 'action=remove');
    });
});
