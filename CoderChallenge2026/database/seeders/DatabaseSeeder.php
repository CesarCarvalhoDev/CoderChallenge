<?php

namespace Database\Seeders;

use App\Models\Agente;
use App\Models\Equipamento;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Popula o banco de dados com equipamentos e agentes para testes da API (F.O.G.O. & PROMETHEUS).
     */
    public function run(): void
    {
        // 1. Radar de Velocidade (Operacional - Manutenção próxima em 3 dias)
        Equipamento::create([
            'numero_serie'                => 'RAD-2026-0001',
            'marca'                       => 'Intelbras',
            'modelo'                      => 'SmartRadar V2',
            'tipo'                        => 'radar',
            'cep'                         => '01310-100',
            'logradouro'                  => 'Avenida Paulista',
            'bairro'                      => 'Bela Vista',
            'cidade'                      => 'São Paulo',
            'uf'                          => 'SP',
            'referencia'                  => 'Em frente ao MASP, sentido Consolação',
            'latitude'                    => -23.561414,
            'longitude'                   => -46.655881,
            'situacao'                    => 'operacional',
            'necessidade_manutencao'      => 'agendada',
            'data_proxima_manutencao'     => now()->addDays(3)->format('Y-m-d'),
            'caracteristicas_especificas' => [
                'subtipo'           => 'velocidade',
                'velocidade_maxima' => 50,
                'faixas_monitoradas'=> 4,
                'leitura_placa_ocr' => true,
            ],
        ]);

        // 2. Câmera de Videomonitoramento (Mau Funcionamento -> Aciona manutenção imediata automaticamente)
        Equipamento::create([
            'numero_serie'                => 'CAM-2026-0002',
            'marca'                       => 'Hikvision',
            'modelo'                      => 'DarkFighter PTZ 360',
            'tipo'                        => 'camera',
            'cep'                         => '01001-000',
            'logradouro'                  => 'Praça da Sé',
            'bairro'                      => 'Centro',
            'cidade'                      => 'São Paulo',
            'uf'                          => 'SP',
            'referencia'                  => 'Poste central próximo à escadaria da Catedral',
            'latitude'                    => -23.550520,
            'longitude'                   => -46.633309,
            'situacao'                    => 'mau_funcionamento',
            'necessidade_manutencao'      => 'imediata',
            'data_proxima_manutencao'     => now()->format('Y-m-d'),
            'caracteristicas_especificas' => [
                'visao_noturna' => true,
                'resolucao'     => '4K',
                'colorida'      => true,
                'angulo_giro'   => '360 graus',
            ],
        ]);

        // 3. Viatura da Guarda Municipal (Operacional - Vinculada a Agente)
        $viaturaGcm = Equipamento::create([
            'numero_serie'                => 'VTR-2026-0003',
            'marca'                       => 'Chevrolet',
            'modelo'                      => 'Tracker GCM',
            'tipo'                        => 'viatura',
            'cep'                         => '01002-020',
            'logradouro'                  => 'Viaduto do Chá',
            'bairro'                      => 'Centro',
            'cidade'                      => 'São Paulo',
            'uf'                          => 'SP',
            'referencia'                  => 'Base operacional em frente à Prefeitura',
            'latitude'                    => -23.547500,
            'longitude'                   => -46.636110,
            'situacao'                    => 'operacional',
            'necessidade_manutencao'      => 'agendada',
            'data_proxima_manutencao'     => now()->addDays(45)->format('Y-m-d'),
            'caracteristicas_especificas' => [
                'placa'               => 'GCM-2026',
                'orgao_responsavel'   => 'Guarda Civil Metropolitana',
                'telemetria_gps_ativa'=> true,
                'camera_embarcada'    => true,
            ],
        ]);

        // 4. Moto de Agente de Trânsito (Operacional - Vinculada a Agente)
        $motoCet = Equipamento::create([
            'numero_serie'                => 'MOT-2026-0004',
            'marca'                       => 'Honda',
            'modelo'                      => 'NC 750X Trânsito',
            'tipo'                        => 'moto',
            'cep'                         => '05424-000',
            'logradouro'                  => 'Largo da Batata',
            'bairro'                      => 'Pinheiros',
            'cidade'                      => 'São Paulo',
            'uf'                          => 'SP',
            'referencia'                  => 'Saída do Metrô Faria Lima',
            'latitude'                    => -23.567020,
            'longitude'                   => -46.693950,
            'situacao'                    => 'operacional',
            'necessidade_manutencao'      => 'nenhuma',
            'data_proxima_manutencao'     => now()->addDays(60)->format('Y-m-d'),
            'caracteristicas_especificas' => [
                'placa'       => 'CET-9012',
                'sirene_led'  => true,
                'baul_radio'  => true,
            ],
        ]);

        // 5. Patinete Elétrico Compartilhado (Furtado - Alerta Crítico)
        Equipamento::create([
            'numero_serie'                => 'PAT-2026-0005',
            'marca'                       => 'Segway',
            'modelo'                      => 'Ninebot Max IoT',
            'tipo'                        => 'patinete',
            'cep'                         => '04538-132',
            'logradouro'                  => 'Avenida Brigadeiro Faria Lima',
            'bairro'                      => 'Itaim Bibi',
            'cidade'                      => 'São Paulo',
            'uf'                          => 'SP',
            'referencia'                  => 'Número 3477 - Último sinal GPS registrado',
            'latitude'                    => -23.586210,
            'longitude'                   => -46.682340,
            'situacao'                    => 'furtado',
            'necessidade_manutencao'      => 'imediata',
            'data_proxima_manutencao'     => null,
            'caracteristicas_especificas' => [
                'nivel_bateria_percentual' => 14,
                'bloqueio_remoto_acionado' => true,
                'velocidade_maxima_kmh'    => 20,
            ],
        ]);

        // 6. Balança de Pesagem de Caminhões (Em Manutenção)
        Equipamento::create([
            'numero_serie'                => 'BAL-2026-0006',
            'marca'                       => 'Toledo',
            'modelo'                      => 'Pesagem Dinâmica HS-WIM',
            'tipo'                        => 'balanca',
            'cep'                         => '02071-000',
            'logradouro'                  => 'Avenida Marginal Tietê',
            'bairro'                      => 'Vila Guilherme',
            'cidade'                      => 'São Paulo',
            'uf'                          => 'SP',
            'referencia'                  => 'KM 14 - Pista Expressa antes da Ponte da Vila Guilherme',
            'latitude'                    => -23.518650,
            'longitude'                   => -46.602410,
            'situacao'                    => 'em_manutencao',
            'necessidade_manutencao'      => 'agendada',
            'data_proxima_manutencao'     => now()->addDays(2)->format('Y-m-d'),
            'caracteristicas_especificas' => [
                'capacidade_maxima_toneladas' => 80,
                'sensor_eixos'                => true,
            ],
        ]);

        // 7. Totem de Estacionamento Rotativo (Ainda Não Instalado)
        Equipamento::create([
            'numero_serie'                => 'TOT-2026-0007',
            'marca'                       => 'Digicon',
            'modelo'                      => 'Parquímetro Solar Pay',
            'tipo'                        => 'totem',
            'cep'                         => '04014-001',
            'logradouro'                  => 'Rua Domingos de Morais',
            'bairro'                      => 'Vila Mariana',
            'cidade'                      => 'São Paulo',
            'uf'                          => 'SP',
            'referencia'                  => 'Oposto ao número 181, próximo ao Metrô Vila Mariana',
            'latitude'                    => -23.589120,
            'longitude'                   => -46.634670,
            'situacao'                    => 'ainda_nao_instalado',
            'necessidade_manutencao'      => 'nenhuma',
            'data_proxima_manutencao'     => null,
            'caracteristicas_especificas' => [
                'aceita_pix'         => true,
                'aceita_cartao_nfc'  => true,
                'painel_solar'       => true,
            ],
        ]);

        // =========================================================================
        // CADASTRO DOS AGENTES DE MOBILIDADE E SEGURANÇA
        // =========================================================================

        Agente::create([
            'matricula'      => 'GCM-10452',
            'nome'           => 'Inspetor Carlos Eduardo Silva',
            'cargo'          => 'guarda_municipal',
            'orgao'          => 'GCM',
            'contato'        => '(11) 98811-2233 / Rádio Alfa-01',
            'situacao'       => 'em_ocorrencia',
            'bairro_atuacao' => 'Centro',
            'latitude'       => -23.550100,
            'longitude'      => -46.633800,
            'equipamento_id' => $viaturaGcm->id,
        ]);

        Agente::create([
            'matricula'      => 'CET-30891',
            'nome'           => 'Mariana Costa Oliveira',
            'cargo'          => 'agente_transito',
            'orgao'          => 'CET',
            'contato'        => '(11) 97722-3344 / Rádio Bravo-12',
            'situacao'       => 'em_atividade',
            'bairro_atuacao' => 'Pinheiros',
            'latitude'       => -23.567020,
            'longitude'      => -46.693950,
            'equipamento_id' => $motoCet->id,
        ]);

        Agente::create([
            'matricula'      => 'PM-88210',
            'nome'           => 'Sargento Roberto Almeida',
            'cargo'          => 'policial_militar',
            'orgao'          => 'PM',
            'contato'        => '190 / Rádio Águia-05',
            'situacao'       => 'em_atividade',
            'bairro_atuacao' => 'Bela Vista',
            'latitude'       => -23.561200,
            'longitude'      => -46.655500,
            'equipamento_id' => null,
        ]);

        Agente::create([
            'matricula'      => 'CET-30945',
            'nome'           => 'Fernando Henrique Santos',
            'cargo'          => 'agente_transito',
            'orgao'          => 'CET',
            'contato'        => '(11) 96655-4411',
            'situacao'       => 'disponivel_base',
            'bairro_atuacao' => 'Vila Mariana',
            'latitude'       => -23.589500,
            'longitude'      => -46.634800,
            'equipamento_id' => null,
        ]);
    }
}