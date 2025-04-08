// document.addEventListener('DOMContentLoaded', function () {
//     let intervalId; // Variable to store the interval ID

//     // Function to check for events and trigger reminders
//     const checkAndSendReminders = async () => {
//         try {
//             // Fetch events from the backend
//             const response = await fetch('/events/check-reminders');
//             const data = await response.json();

//             if (data.success && data.events.length > 0) {
//                 console.log('Reminders sent for the following events:', data.events);

//                 // Stop the interval after reminders are sent
//                 clearInterval(intervalId);
//                 console.log('Reminder requests stopped.');
//             } else {
//                 console.log('No reminders to send.');
//             }
//         } catch (error) {
//             console.error('Error checking and sending reminders:', error);

//             // Optional: Stop the interval if there's an error
//             clearInterval(intervalId);
//             console.log('Reminder requests stopped due to an error.');
//         }
//     };

//     // Run the function every 5 seconds
//     intervalId = setInterval(checkAndSendReminders, 5 * 1000); // Adjust as needed
//     checkAndSendReminders(); // Run immediately on page load
// });