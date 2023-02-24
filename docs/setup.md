# Instructies voor het opbouwen van het project

## Benodigheden
- sql
- php
- composer 
- npm

## Opbouwen
Nadat het project is gecloned, moet je de volgende commands uitvoeren voor het volgende

### Setup commands
```
composer install
npm install
php artisan storage:link
```
### Alleen voor Windows
```
copy .env.example .env
php artisan key:generate
```

### Alleen voor MacOS
```
cp .env.example .env
php artisan key:generate
```


### Data importen van API
voor het importeren van alle drankjes wordt de eerste command gebruikt, deze command maakt jobs aan die met de 2e command kunnen worden uitgevoerd.
```
php artisan import:data
php artisan queue:work database --queue=drinks,ingredients,categories,glasses
```

### Commands voor het opstarten van de applicatie
Nadat de vorige commands zijn uitgevoerd, is het tijd om de applicatie op te starten
```
mysql.server start     
php artisan serve       
npm run dev             
```


