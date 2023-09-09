// Get the necessary elements
const accountSettings = document.querySelector('.account-settings');
const userAccountItems = document.querySelector('.user-account-items');

// Add event listener to the accountSettings to toggle the visibility of userAccountItems
accountSettings.addEventListener('click', function() {
  userAccountItems.classList.toggle('show');
  accountSettings.classList.toggle('selected');
});

// Close userAccountItems when clicking outside of it
document.addEventListener('click', function(event) {
  if (!accountSettings.contains(event.target) && !userAccountItems.contains(event.target)) {
    userAccountItems.classList.remove('show');
    accountSettings.classList.remove('selected');
  }
});
