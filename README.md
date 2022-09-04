# Controlpanel Ticketsystem 

Fully functional Client Ticket system.

#### Features
 - Client Tickets
 - Email Notification System for Admins and Clients
 - Discord Notification System using Webhooks
 - Blacklist (ban users from creating Tickets)



## Installation

Run this from your Terminal inside your Controlpanel directory (usually /var/www/controlpanel)
<br/>
`composer require 1day2die/cpgg-ticketsystem`
`php artisan migrate`

## Usage
You will find a new Settings tab for the Ticketsystem.
This way you can enable/disable the whole system and set the Webhooks for Discord Messages
