<?php

namespace App\Console\Commands;

use App\Models\Daily;
use App\Models\Room;
use Illuminate\Console\Command;
use App\Models\Hotel;
use App\Models\Reserve;
use App\Models\Guest;
use App\Models\Payment;


class ImportarDadosXml extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:importar-dados-xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hotelXmlPath = storage_path('app/xml/hotels.xml');
        $reservesXmlPath = storage_path('app/xml/reserves.xml');
        $roomsXmlPath = storage_path('app/xml/rooms.xml');

        $this->importarHotels($hotelXmlPath);
        $this->importarReserves($reservesXmlPath);
        $this->importarRooms ($roomsXmlPath);

        $this->info('Importação concluída.');
    }

    private function importarHotels($xmlPath){
        $dados = simplexml_load_file($xmlPath);


        //$this->info(print_r($dados, true));

        if (!isset($dados->Hotel)) {
            $this->error('Nenhum hotel encontrado no arquivo XML.');
            return;
        }
        foreach($dados->Hotel as $hotel){
            $hotelId = (string) $hotel['id'];
            $hotelName = (string)$hotel->Name;

            $this->info("Importando hotel: ID = {$hotelId}, Nome = {$hotelName}");
            
            Hotel::updateOrCreate(
                ['id' => (int)$hotelId],
                ['name' => $hotelName]
            );
        }   
    }

    private function importarRooms($xmlPath){
        $this->info('Importando quartos...');

        $dados = simplexml_load_file($xmlPath);

        //$this->info(print_r($dados, true));

        if (!isset($dados->Room)) {
            $this->error('Nenhum quarto encontrado no arquivo XML.');
            return;
        }

        foreach($dados->Room as $room){                             
            $roomId = (string) $room['id'];
            $hotelId = (string)$room['hotelCode'];
            $roomName = (string)$room->Name;
            
            $this->info("Importando quarto: ID = {$roomId}, Nome = {$roomName}, Hotel = {$hotelId}");

            $hotel = Hotel::find((int)$room['hotelCode']);

            if($hotel){
                Room::updateOrCreate(
                    ['id' => (int)$roomId],
                    ['name' => $roomName, 'hotelCode' => (int)$hotelId],
                );
            }else{
                echo"Hotel com código{$room->Hotel['id']} não encontrado";
            }


        }
    }

    private function importarReserves($xmlPath){
        $this->info('Importando reservas');

        $dados = simplexml_load_file($xmlPath);

        //$this->info(print_r($dados, true));

        if(!isset($dados->Reserve)){
            $this->error('Nenhuma reservsa encontrada no arquivo XML.');
            return;
        }

        $Reserva = $dados->Reserve;

        foreach($dados->Reserve as $reserve){
            $reserveId = (int) $reserve['id'];
            $hotelId = (int)$reserve['hotelCode'];
            $roomId = (int)$reserve['roomCode'];
            $checkIn = (string)$reserve->CheckIn;
            $checkOut = (string)$reserve->CheckOut;
            $total = (float)$reserve->Total;
            //$nomeHospede = (string)$reserve->Guests->Guest->Name;
            //$dataDiaria = (string)$reserve->Dailies->Daily->Date;
            //$guestCode = $reserve['guestCode'] ?? Guest::create(['name' => 'default', 'lastName' => 'default', 'phone' => 988689092])->id;
            //$dateDailyCode = $reserve['dateDailyCode'] ?? Daily::create(['date' => '2024-01-01', 'value' => 0.0])->id;
            //$paymentCode = $reserve['paymentCode'] ?? Payment::create(['method' => 1, 'value' => 0.0])->id;
            $guestCode = (int)$reserve['guestCode'];
            $dateDailyCode = (int)$reserve['dateDailyCode'];
            $paymentCode = (int)$reserve['paymentCode'];

            $this->info("Importando reserva: ID = {$reserveId}, Hotel = {$hotelId}, Room = {$roomId}");

            $hotel = Hotel::find((int)$reserve['hotelCode']);

            $room = Room::find((int)$reserve['roomCode']);

            if($hotel && $room){
                Reserve::updateOrCreate(
                    ['id' => (int)$reserveId],
                    ['hotelCode' => (int)$hotelId,
                    'roomCode' => (int)$roomId,
                    'checkIn' => (string)$checkIn,
                    'checkOut' => (string)$checkOut,
                    'total' => (float)$total,
                ]);

                foreach($reserve->Guests->Guest as $hospedes){
        
                    $this->info("Importando hospede: ID da reserva = {$reserveId}, Nome = {$hospedes->Name}");
                    //colocar o hospede pra ligar com a reserva atraves da fk de reserva  
                    Guest::updateOrCreate(
                        ['name' => $hospedes->Name,
                        'lastName' => $hospedes->LastName,
                        'phone' => $hospedes->Phone,
                        'reserve_id' => $reserveId]
                    );
                }
        
                foreach($reserve->Dailies->Daily as $diarias){
        
                    $this->info("Importando dia: ID da reserva = {$reserveId}, Data = {$diarias->Date}");
        
                    Daily::updateOrCreate(
                        ['date' => $diarias->Date,
                        'value' => $diarias->Value,
                        'reserve_id' => $reserveId] 
                    );
                }
        
                if(isset($reserve->Payments->Payment)){
                    $totalDiarias = Payment::where('reserve_id', $reserveId)->sum('value');
                    $this->info("Total de diarias = {$totalDiarias}");
                    if($totalDiarias < $total){
                        foreach($reserve->Payments->Payment as $pagamentos){
                            $this->info("Importando pagamento: ID da reserva = {$reserveId}, Metodo = {$pagamentos->Method}, Total = {$total}");
                            
                            Payment::updateOrCreate(
                                ['method' => $pagamentos->Method,
                                'value' => $pagamentos->Value,
                                'reserve_id' => $reserveId]
                            );
                        }                        
                    }else{
                        $this->info("O pagamento de todas as diarias ja foram efetuadas");
                    }
                }else{
                    $this->info("Nenhum pagamento encontrado para essa reserva");
                }
            }
            
        }

        $this->info('Importação concluída.');
    }
}