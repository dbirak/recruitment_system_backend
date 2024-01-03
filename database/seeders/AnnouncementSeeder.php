<?php

namespace Database\Seeders;

use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Announcement::truncate();
        Schema::enableForeignKeyConstraints();
        Announcement::upsert(
            [
                [
                    'name' => 'Młodszy programista JAVA',
                    'description' => 'Jesteśmy firmą poszukującą ambitnych i utalentowanych młodszych programistów Java, którzy chcą rozwijać swoje umiejętności w dynamicznym środowisku pracy. Jako Młodszy Programista Java dołączysz do naszego zespołu programistycznego i będziesz uczestniczyć w tworzeniu oraz rozwijaniu oprogramowania, a także wdrażaniu innowacyjnych rozwiązań technologicznych.',
                    'duties' => json_encode([
                        'Tworzenie, testowanie i wdrażanie aplikacji w języku Java.',
                        'Współpraca z zespołem deweloperskim w celu rozwijania oprogramowania zgodnie z wymaganiami.',
                        'Pisanie czytelnego i efektywnego kodu oraz udział w jego ocenie i optymalizacji.',
                        'Uczestnictwo w procesie analizy i projektowania rozwiązań programistycznych.',
                        'Rozwiązywanie problemów i debugowanie istniejącego kodu.',
                        'Dokumentowanie pracy programistycznej i tworzenie raportów dotyczących postępów w projekcie.',
                    ]),
                    'requirements' => json_encode([
                        'Wyższe wykształcenie (preferowane kierunki związane z informatyką lub inżynierią oprogramowania).',
                        'Znajomość języka Java oraz podstawowych technologii związanych z programowaniem obiektowym.',
                        'Umiejętność pracy w zespole oraz dobra komunikatywność.',
                        'Chęć nauki i zdobywania nowych umiejętności programistycznych.',
                        'Znajomość podstawowych koncepcji związanych z bazami danych (SQL) będzie dodatkowym atutem.',
                    ]),
                    'offer' => json_encode([
                        'Możliwość rozwoju zawodowego i zdobycia doświadczenia w międzynarodowym środowisku pracy.',
                        'Elastyczne godziny pracy i przestrzeń do wyrażania własnych pomysłów.',
                        'Profesjonalne szkolenia i wsparcie w rozwoju umiejętności programistycznych.',
                        'Konkurencyjne wynagrodzenie oraz pakiet benefitów (np. prywatna opieka medyczna, karta sportowa).',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(10)->toDateString(),
                    'min_earn' => 35.00,
                    'max_earn' => 45.00,
                    'earn_time_id' => 4,
                    'contract_id' => 1,
                    'company_id' => 9,
                    'category_id' => 7,
                    'work_time_id' => 3,
                    'work_type_id' => 2,
                ],
                [
                    'name' => 'Kucharz w restauracji',
                    'description' => 'Poszukujemy doświadczonego i kreatywnego kucharza, który dołączy do naszego zespołu w restauracji. Osoba na tym stanowisku będzie odpowiedzialna za przygotowywanie wysokiej jakości dań, dbając o ich smak, estetykę i zgodność z oczekiwaniami naszych gości.',
                    'duties' => json_encode([
                        'Przygotowywanie potraw zgodnie z ustalonymi recepturami i standardami jakościowymi.',
                        'Zapewnienie zachowania wysokich standardów higieny i bezpieczeństwa w miejscu pracy.',
                        'Monitorowanie stanu zapasów i zamawianie potrzebnych produktów spożywczych.',
                        'Współpraca z zespołem kuchennym w celu utrzymania płynności pracy podczas intensywnych okresów.',
                        'Kreatywne podejście do opracowywania nowych dań i wprowadzanie innowacji do menu.',
                    ]),
                    'requirements' => json_encode([
                        'Doświadczenie zawodowe w pracy na podobnym stanowisku w restauracji.',
                        'Znajomość technik kulinarnych oraz umiejętność przygotowywania różnorodnych dań.',
                        'Umiejętność pracy w dynamicznym środowisku i skuteczne radzenie sobie z presją czasu.',
                        'Dbałość o szczegóły i kreatywność w kreowaniu dań.',
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w renomowanej restauracji.',
                        'Możliwość rozwoju zawodowego i podnoszenia kwalifikacji w pracy z różnymi rodzajami kuchni.',
                        'Elastyczny grafik pracy i wsparcie ze strony zespołu.',
                        'Konkurencyjne wynagrodzenie oraz inne benefity.',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(8)->toDateString(),
                    'min_earn' => 5500.00,
                    'max_earn' => NULL,
                    'earn_time_id' => 1,
                    'contract_id' => 3,
                    'company_id' => 8,
                    'category_id' => 5,
                    'work_time_id' => 3,
                    'work_type_id' => 1,
                ],
                [
                    'name' => 'Księgowy w sklepie zoologicznym',
                    'description' => 'Poszukujemy doświadczonej osoby na stanowisko księgowego w sklepie zoologicznym. Osoba zatrudniona na tym stanowisku będzie odpowiedzialna za prowadzenie księgowości firmy, monitorowanie dokumentów finansowych oraz zachowanie dokładności i rzetelności w rejestracji danych księgowych.',
                    'duties' => json_encode([
                        'Prowadzenie pełnej księgowości: ewidencja przychodów, deklaracje podatkowe, rozliczenia z dostaw.',
                        'Sporządzanie/analiza raportów finansowych, sprawozdań, zestawień zgodnie z przepisami.',
                        'Utrzymywanie kontaktów z instytucjami finansowymi, organami kontrolnymi.',
                        'Zapewnienie zgodności dokumentacji z obowiązującymi standardami/przepisami.',
                        'Współpraca z innymi działami w celu spójności danych księgowych.',
                    ]),
                    'requirements' => json_encode([
                        'Doświadczenie w pracy jako księgowy lub podobnie.',
                        'Znajomość przepisów rachunkowości, prawa podatkowego.',
                        'Umiejętność pracy w programach księgowych, MS Office.',
                        'Precyzja, skrupulatność, dobra organizacja.',
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w renomowanym sklepie zoologicznym.',
                        'Możliwość rozwoju, zdobywania doświadczenia w księgowości.',
                        'Przyjazne środowisko pracy, wsparcie ze strony zespołu.',
                        'Konkurencyjne wynagrodzenie zgodne z doświadczeniem, umiejętnościami.',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(12)->toDateString(),
                    'min_earn' => NULL,
                    'max_earn' => NULL,
                    'earn_time_id' => NULL,
                    'contract_id' => 4,
                    'company_id' => 7,
                    'category_id' => 4,
                    'work_time_id' => 2,
                    'work_type_id' => 2,
                ],
                [
                    'name' => 'Kierowca tira',
                    'description' => 'Firma transportowa poszukuje doświadczonego kierowcy Tira. Osoba na tym stanowisku będzie odpowiedzialna za prowadzenie pojazdu ciężarowego, zapewnienie terminowych dostaw towarów oraz dbanie o bezpieczeństwo podczas podróży.',
                    'duties' => json_encode([
                        'Prowadzenie pojazdu ciężarowego zgodnie z obowiązującymi przepisami prawa drogowego.',
                        'Realizacja terminowych dostaw towarów do klientów firmy.',
                        'Utrzymywanie pojazdu w czystości i regularne przeprowadzanie konserwacji.',
                        'Monitorowanie stanu technicznego pojazdu oraz raportowanie ewentualnych usterek.',
                        'Dbałość o bezpieczeństwo własne oraz innych uczestników ruchu drogowego.',
                    ]),
                    'requirements' => json_encode([
                        'Posiadanie prawa jazdy kategorii C+E oraz doświadczenie w transporcie międzynarodowym.',
                        'Znajomość przepisów dotyczących przewozu towarów oraz tachografu cyfrowego.',
                        'Umiejętność pracy w zespole oraz komunikatywność.',
                        'Zaangażowanie w wykonywane obowiązki oraz zdolność radzenia sobie w sytuacjach stresowych.',
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w renomowanej firmie transportowej.',
                        'Atrakcyjne wynagrodzenie adekwatne do doświadczenia i umiejętności.',
                        'Praca w dynamicznym środowisku i możliwość rozwoju zawodowego.',
                        'Elastyczny grafik pracy i profesjonalne wsparcie.',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(17)->toDateString(),
                    'min_earn' => 5500.00,
                    'max_earn' => 6300.00,
                    'earn_time_id' => 2,
                    'contract_id' => 1,
                    'company_id' => 6,
                    'category_id' => 16,
                    'work_time_id' => 3,
                    'work_type_id' => 4,
                ],
                [
                    'name' => 'Pracownik hurtowni odzieży',
                    'description' => 'Poszukujemy osoby do pracy w hurtowni odzieży. Pracownik będzie odpowiedzialny za obsługę klienta, zarządzanie zamówieniami oraz dbanie o właściwe funkcjonowanie magazynu.',
                    'duties' => json_encode([
                        'Obsługa klienta hurtowego: przyjmowanie zamówień, udzielanie informacji o asortymencie.',
                        'Prowadzenie dokumentacji związanej z przyjęciem i wydaniem towaru.',
                        'Kompletowanie zamówień, dbanie o odpowiednie ulokowanie towarów w magazynie.',
                        'Współpraca z działem logistyki w celu zapewnienia prawidłowej dostawy towaru.',
                        'Utrzymywanie porządku i czystości w miejscu pracy.',
                    ]),
                    'requirements' => json_encode([
                        'Umiejętność obsługi klienta i doświadczenie w pracy handlowej będzie mile widziane.',
                        'Znajomość podstaw magazynowych oraz umiejętność pracy z dokumentacją.',
                        'Komunikatywność, zaangażowanie i gotowość do pracy w dynamicznym środowisku.',
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w firmie o ugruntowanej pozycji na rynku.',
                        'Przyjazną atmosferę pracy i wsparcie ze strony zespołu.',
                        'Możliwość rozwoju zawodowego i zdobycia doświadczenia w branży odzieżowej.',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(6)->toDateString(),
                    'min_earn' => NULL,
                    'max_earn' => NULL,
                    'earn_time_id' => NULL,
                    'contract_id' => 1,
                    'company_id' => 5,
                    'category_id' => 13,
                    'work_time_id' => 1,
                    'work_type_id' => 1,
                ],
                [
                    'name' => 'Wydawca w wydawnictwie książkowym',
                    'description' => 'Poszukujemy kreatywnej i zaangażowanej osoby na stanowisko wydawcy w naszym wydawnictwie książkowym. Osoba na tym stanowisku będzie odpowiedzialna za opracowywanie i nadzorowanie projektów wydawniczych od momentu ich powstania do publikacji.',
                    'duties' => json_encode([
                        'Ocena i wybór manuskryptów, kontakt z autorami w celu opracowania i korekty tekstu.',
                        'Nadzór nad procesem redakcyjnym, korektą merytoryczną i językową publikacji.',
                        'Planowanie i organizacja prac wydawniczych, współpraca z zespołem projektowym.',
                        'Prowadzenie negocjacji z autorami oraz współpraca z drukarniami i innymi partnerami z branży.',
                    ]),
                    'requirements' => json_encode([
                        'Doświadczenie w pracy redaktorskiej lub wydawniczej w branży książkowej.',
                        'Znajomość procesu powstawania książki, umiejętności redakcyjne i językowe.',
                        'Kreatywność, umiejętność analizy tekstów oraz zdolność redagowania i korekty.',
                        'Komunikatywność i umiejętność nawiązywania relacji z autorami i partnerami biznesowymi.',
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w renomowanym wydawnictwie książkowym.',
                        'Możliwość rozwijania umiejętności redakcyjnych i wydawniczych.',
                        'Inspirowanie środowisko pracy, wsparcie ze strony doświadczonego zespołu.',
                        'Elastyczne godziny pracy i konkurencyjne wynagrodzenie.',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(8)->toDateString(),
                    'min_earn' => '42.00',
                    'max_earn' => NULL,
                    'earn_time_id' => 4,
                    'contract_id' => 1,
                    'company_id' => 4,
                    'category_id' => 11,
                    'work_time_id' => 3,
                    'work_type_id' => 1,
                ],
                [
                    'name' => 'Pracownik obsługi klienta',
                    'description' => 'Poszukujemy pracownika do hurtowni elektroniki "ELEKTRO-PLUS". Osoba na tym stanowisku będzie odpowiedzialna za obsługę klienta, zarządzanie zamówieniami oraz dbanie o właściwe funkcjonowanie magazynu.',
                    'duties' => json_encode([
                        'Obsługa klienta: przyjmowanie zamówień, udzielanie informacji o produktach elektronicznych.',
                        'Prowadzenie dokumentacji związanej z przyjęciem i wydaniem towaru.',
                        'Kompletowanie zamówień, dbanie o właściwe rozmieszczenie i stan magazynu.',
                        'Współpraca z działem logistyki w celu zapewnienia terminowej dostawy towaru.',
                        'Utrzymywanie porządku i czystości w miejscu pracy.',
                    ]),
                    'requirements' => json_encode([
                        'Doświadczenie w obsłudze klienta lub pracy w branży elektronicznej będzie mile widziane.',
                        'Znajomość podstaw magazynowych oraz umiejętność pracy z dokumentacją.',
                        'Komunikatywność, zaangażowanie i gotowość do pracy w dynamicznym środowisku.',
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w firmie o renomie "ELEKTRO-PLUS".',
                        'Przyjazną atmosferę pracy i wsparcie ze strony zespołu.',
                        'Możliwość rozwoju zawodowego i zdobycia doświadczenia w branży elektronicznej.',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(16)->toDateString(),
                    'min_earn' => NULL,
                    'max_earn' => NULL,
                    'earn_time_id' => 1,
                    'contract_id' => 3,
                    'company_id' => 3,
                    'category_id' => 3,
                    'work_time_id' => 1,
                    'work_type_id' => 1,
                ],
                [
                    'name' => 'Technik budowlany',
                    'description' => 'Poszukujemy doświadczonego technika budowlanego, który będzie odpowiedzialny za nadzór i koordynację prac budowlanych, zapewniając wysoki poziom jakości i terminowość realizacji projektów.',
                    'duties' => json_encode([
                        'Nadzór nad realizacją etapów budowy, zapewnienie zgodności z projektem i standardami.',
                        'Koordynacja pracowników budowlanych oraz współpraca z podwykonawcami.',
                        'Wykonywanie pomiarów i kontrola jakości wykonywanych robót.',
                        'Raportowanie postępów i problemów w realizacji projektów do kierownictwa.',
                    ]),
                    'requirements' => json_encode([
                        'Wykształcenie wyższe techniczne (preferowane kierunki związane z budownictwem).',
                        'Doświadczenie w nadzorze nad pracami budowlanymi oraz w pracy na podobnym stanowisku.',
                        'Znajomość przepisów budowlanych i procedur nadzoru inwestorskiego.',
                        'Umiejętności komunikacyjne, organizacyjne oraz analityczne.',
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w renomowanej firmie budowlanej "BudMaster" Sp. z o.o.',
                        'Możliwość rozwoju zawodowego i zdobywania doświadczenia w różnorodnych projektach.',
                        'Przyjazne środowisko pracy oraz wsparcie ze strony profesjonalnego zespołu.',
                    ]),
                    'expiry_date' => Carbon::now()->addDays(11)->toDateString(),
                    'min_earn' => NULL,
                    'max_earn' => NULL,
                    'earn_time_id' => 3,
                    'contract_id' => 2,
                    'company_id' => 2,
                    'category_id' => 4,
                    'work_time_id' => 2,
                    'work_type_id' => 4,
                ],
                [
                    'name' => 'Specjalista do spraw marketingu w agencji reklamowej',
                    'description' => 'Poszukujemy kreatywnej i zdolnej osoby na stanowisko specjalisty ds. marketingu w agencji reklamowej. Poszukiwany pracownik będzie odpowiedzialny za opracowywanie, wdrażanie i monitorowanie strategii marketingowych dla klientów.',
                    'duties' => json_encode([
                        'Opracowywanie spersonalizowanych strategii marketingowych zgodnych z potrzebami klientów.',
                        'Kreowanie i realizacja kompleksowych kampanii reklamowych zarówno online, jak i offline.',
                        'Tworzenie różnorodnych treści marketingowych i materiałów promocyjnych.',
                        'Analiza danych, monitorowanie trendów rynkowych oraz raportowanie wyników działań marketingowych.',
                        'Współpraca z klientami w celu zrozumienia ich potrzeb i dostarczania wysokiej jakości rozwiązań.'
                    ]),
                    'requirements' => json_encode([
                        'Doświadczenie w obszarze marketingu (preferowane w agencji reklamowej).',
                        'Znajomość narzędzi i technik marketingowych online i offline.',
                        'Umiejętność analitycznego myślenia, kreatywność i doskonałe umiejętności komunikacyjne.',
                        'Zainteresowanie trendami marketingowymi oraz umiejętność pracy w dynamicznym środowisku.'
                    ]),
                    'offer' => json_encode([
                        'Stabilne zatrudnienie w agencji reklamowej z ugruntowaną pozycją na rynku.',
                        'Możliwość pracy nad różnorodnymi projektami dla różnych klientów.',
                        'Przyjazne środowisko pracy, wsparcie zespołu oraz możliwość rozwoju zawodowego.'
                    ]),
                    'expiry_date' => Carbon::now()->addDays(18)->toDateString(),
                    'min_earn' => 5400.00,
                    'max_earn' => 6200.00,
                    'earn_time_id' => 2,
                    'contract_id' => 1,
                    'company_id' => 1,
                    'category_id' => 1,
                    'work_time_id' => 1,
                    'work_type_id' => 3,
                ]
            ],
            'name'
        );
    }
}
