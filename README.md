# Play Tennis
> Find tennis players near you

Don't forget to setup cron:
```
/usr/local/php72/bin/php /home/figlimig/playtennis.com.ua/www/artisan schedule:run >> /dev/null 2>&1
```

## Email routing
For routing used Send Pulse [sendpulse.com]
To export all users as csv use query: `select email, name from users`