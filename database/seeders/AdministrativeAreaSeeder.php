<?php

declare(strict_types=1);

namespace Blamodex\Address\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdministrativeAreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // G20 nations: US, CA, MX, BR, AR, UK, DE, FR, IT, EU, RU, TR, SA, ZA, IN, CN, JP, KR, AU, ID
            $administrativeAreas = [
            // United States (US)
            ['code' => 'US', 'administrative_area' => 'Alabama', 'administrative_area_code' => 'AL'],
            ['code' => 'US', 'administrative_area' => 'Alaska', 'administrative_area_code' => 'AK'],
            ['code' => 'US', 'administrative_area' => 'Arizona', 'administrative_area_code' => 'AZ'],
            ['code' => 'US', 'administrative_area' => 'Arkansas', 'administrative_area_code' => 'AR'],
            ['code' => 'US', 'administrative_area' => 'California', 'administrative_area_code' => 'CA'],
            ['code' => 'US', 'administrative_area' => 'Colorado', 'administrative_area_code' => 'CO'],
            ['code' => 'US', 'administrative_area' => 'Connecticut', 'administrative_area_code' => 'CT'],
            ['code' => 'US', 'administrative_area' => 'Delaware', 'administrative_area_code' => 'DE'],
            ['code' => 'US', 'administrative_area' => 'Florida', 'administrative_area_code' => 'FL'],
            ['code' => 'US', 'administrative_area' => 'Georgia', 'administrative_area_code' => 'GA'],
            ['code' => 'US', 'administrative_area' => 'Hawaii', 'administrative_area_code' => 'HI'],
            ['code' => 'US', 'administrative_area' => 'Idaho', 'administrative_area_code' => 'ID'],
            ['code' => 'US', 'administrative_area' => 'Illinois', 'administrative_area_code' => 'IL'],
            ['code' => 'US', 'administrative_area' => 'Indiana', 'administrative_area_code' => 'IN'],
            ['code' => 'US', 'administrative_area' => 'Iowa', 'administrative_area_code' => 'IA'],
            ['code' => 'US', 'administrative_area' => 'Kansas', 'administrative_area_code' => 'KS'],
            ['code' => 'US', 'administrative_area' => 'Kentucky', 'administrative_area_code' => 'KY'],
            ['code' => 'US', 'administrative_area' => 'Louisiana', 'administrative_area_code' => 'LA'],
            ['code' => 'US', 'administrative_area' => 'Maine', 'administrative_area_code' => 'ME'],
            ['code' => 'US', 'administrative_area' => 'Maryland', 'administrative_area_code' => 'MD'],
            ['code' => 'US', 'administrative_area' => 'Massachusetts', 'administrative_area_code' => 'MA'],
            ['code' => 'US', 'administrative_area' => 'Michigan', 'administrative_area_code' => 'MI'],
            ['code' => 'US', 'administrative_area' => 'Minnesota', 'administrative_area_code' => 'MN'],
            ['code' => 'US', 'administrative_area' => 'Mississippi', 'administrative_area_code' => 'MS'],
            ['code' => 'US', 'administrative_area' => 'Missouri', 'administrative_area_code' => 'MO'],
            ['code' => 'US', 'administrative_area' => 'Montana', 'administrative_area_code' => 'MT'],
            ['code' => 'US', 'administrative_area' => 'Nebraska', 'administrative_area_code' => 'NE'],
            ['code' => 'US', 'administrative_area' => 'Nevada', 'administrative_area_code' => 'NV'],
            ['code' => 'US', 'administrative_area' => 'New Hampshire', 'administrative_area_code' => 'NH'],
            ['code' => 'US', 'administrative_area' => 'New Jersey', 'administrative_area_code' => 'NJ'],
            ['code' => 'US', 'administrative_area' => 'New Mexico', 'administrative_area_code' => 'NM'],
            ['code' => 'US', 'administrative_area' => 'New York', 'administrative_area_code' => 'NY'],
            ['code' => 'US', 'administrative_area' => 'North Carolina', 'administrative_area_code' => 'NC'],
            ['code' => 'US', 'administrative_area' => 'North Dakota', 'administrative_area_code' => 'ND'],
            ['code' => 'US', 'administrative_area' => 'Ohio', 'administrative_area_code' => 'OH'],
            ['code' => 'US', 'administrative_area' => 'Oklahoma', 'administrative_area_code' => 'OK'],
            ['code' => 'US', 'administrative_area' => 'Oregon', 'administrative_area_code' => 'OR'],
            ['code' => 'US', 'administrative_area' => 'Pennsylvania', 'administrative_area_code' => 'PA'],
            ['code' => 'US', 'administrative_area' => 'Rhode Island', 'administrative_area_code' => 'RI'],
            ['code' => 'US', 'administrative_area' => 'South Carolina', 'administrative_area_code' => 'SC'],
            ['code' => 'US', 'administrative_area' => 'South Dakota', 'administrative_area_code' => 'SD'],
            ['code' => 'US', 'administrative_area' => 'Tennessee', 'administrative_area_code' => 'TN'],
            ['code' => 'US', 'administrative_area' => 'Texas', 'administrative_area_code' => 'TX'],
            ['code' => 'US', 'administrative_area' => 'Utah', 'administrative_area_code' => 'UT'],
            ['code' => 'US', 'administrative_area' => 'Vermont', 'administrative_area_code' => 'VT'],
            ['code' => 'US', 'administrative_area' => 'Virginia', 'administrative_area_code' => 'VA'],
            ['code' => 'US', 'administrative_area' => 'Washington', 'administrative_area_code' => 'WA'],
            ['code' => 'US', 'administrative_area' => 'West Virginia', 'administrative_area_code' => 'WV'],
            ['code' => 'US', 'administrative_area' => 'Wisconsin', 'administrative_area_code' => 'WI'],
            ['code' => 'US', 'administrative_area' => 'Wyoming', 'administrative_area_code' => 'WY'],
            // Canada (CA)
            ['code' => 'CA', 'administrative_area' => 'Alberta', 'administrative_area_code' => 'AB'],
            ['code' => 'CA', 'administrative_area' => 'British Columbia', 'administrative_area_code' => 'BC'],
            ['code' => 'CA', 'administrative_area' => 'Manitoba', 'administrative_area_code' => 'MB'],
            ['code' => 'CA', 'administrative_area' => 'New Brunswick', 'administrative_area_code' => 'NB'],
            ['code' => 'CA', 'administrative_area' => 'Newfoundland and Labrador', 'administrative_area_code' => 'NL'],
            ['code' => 'CA', 'administrative_area' => 'Nova Scotia', 'administrative_area_code' => 'NS'],
            ['code' => 'CA', 'administrative_area' => 'Ontario', 'administrative_area_code' => 'ON'],
            ['code' => 'CA', 'administrative_area' => 'Prince Edward Island', 'administrative_area_code' => 'PE'],
            ['code' => 'CA', 'administrative_area' => 'Quebec', 'administrative_area_code' => 'QC'],
            ['code' => 'CA', 'administrative_area' => 'Saskatchewan', 'administrative_area_code' => 'SK'],
            ['code' => 'CA', 'administrative_area' => 'Northwest Territories', 'administrative_area_code' => 'NT'],
            ['code' => 'CA', 'administrative_area' => 'Nunavut', 'administrative_area_code' => 'NU'],
            ['code' => 'CA', 'administrative_area' => 'Yukon', 'administrative_area_code' => 'YT'],
            // Mexico (MX)
            ['code' => 'MX', 'administrative_area' => 'Aguascalientes', 'administrative_area_code' => 'AGU'],
            ['code' => 'MX', 'administrative_area' => 'Baja California', 'administrative_area_code' => 'BCN'],
            ['code' => 'MX', 'administrative_area' => 'Baja California Sur', 'administrative_area_code' => 'BCS'],
            ['code' => 'MX', 'administrative_area' => 'Campeche', 'administrative_area_code' => 'CAM'],
            ['code' => 'MX', 'administrative_area' => 'Chiapas', 'administrative_area_code' => 'CHP'],
            ['code' => 'MX', 'administrative_area' => 'Chihuahua', 'administrative_area_code' => 'CHH'],
            ['code' => 'MX', 'administrative_area' => 'Coahuila', 'administrative_area_code' => 'COA'],
            ['code' => 'MX', 'administrative_area' => 'Colima', 'administrative_area_code' => 'COL'],
            ['code' => 'MX', 'administrative_area' => 'Durango', 'administrative_area_code' => 'DUR'],
            ['code' => 'MX', 'administrative_area' => 'Guanajuato', 'administrative_area_code' => 'GUA'],
            ['code' => 'MX', 'administrative_area' => 'Guerrero', 'administrative_area_code' => 'GRO'],
            ['code' => 'MX', 'administrative_area' => 'Hidalgo', 'administrative_area_code' => 'HID'],
            ['code' => 'MX', 'administrative_area' => 'Jalisco', 'administrative_area_code' => 'JAL'],
            ['code' => 'MX', 'administrative_area' => 'Mexico State', 'administrative_area_code' => 'MEX'],
            ['code' => 'MX', 'administrative_area' => 'Michoacán', 'administrative_area_code' => 'MIC'],
            ['code' => 'MX', 'administrative_area' => 'Morelos', 'administrative_area_code' => 'MOR'],
            ['code' => 'MX', 'administrative_area' => 'Nayarit', 'administrative_area_code' => 'NAY'],
            ['code' => 'MX', 'administrative_area' => 'Nuevo León', 'administrative_area_code' => 'NLE'],
            ['code' => 'MX', 'administrative_area' => 'Oaxaca', 'administrative_area_code' => 'OAX'],
            ['code' => 'MX', 'administrative_area' => 'Puebla', 'administrative_area_code' => 'PUE'],
            ['code' => 'MX', 'administrative_area' => 'Querétaro', 'administrative_area_code' => 'QUE'],
            ['code' => 'MX', 'administrative_area' => 'Quintana Roo', 'administrative_area_code' => 'ROO'],
            ['code' => 'MX', 'administrative_area' => 'San Luis Potosí', 'administrative_area_code' => 'SLP'],
            ['code' => 'MX', 'administrative_area' => 'Sinaloa', 'administrative_area_code' => 'SIN'],
            ['code' => 'MX', 'administrative_area' => 'Sonora', 'administrative_area_code' => 'SON'],
            ['code' => 'MX', 'administrative_area' => 'Tabasco', 'administrative_area_code' => 'TAB'],
            ['code' => 'MX', 'administrative_area' => 'Tamaulipas', 'administrative_area_code' => 'TAM'],
            ['code' => 'MX', 'administrative_area' => 'Tlaxcala', 'administrative_area_code' => 'TLA'],
            ['code' => 'MX', 'administrative_area' => 'Veracruz', 'administrative_area_code' => 'VER'],
            ['code' => 'MX', 'administrative_area' => 'Yucatán', 'administrative_area_code' => 'YUC'],
            ['code' => 'MX', 'administrative_area' => 'Zacatecas', 'administrative_area_code' => 'ZAC'],
            // Brazil (BR)
            ['code' => 'BR', 'administrative_area' => 'Acre', 'administrative_area_code' => 'AC'],
            ['code' => 'BR', 'administrative_area' => 'Alagoas', 'administrative_area_code' => 'AL'],
            ['code' => 'BR', 'administrative_area' => 'Amapá', 'administrative_area_code' => 'AP'],
            ['code' => 'BR', 'administrative_area' => 'Amazonas', 'administrative_area_code' => 'AM'],
            ['code' => 'BR', 'administrative_area' => 'Bahia', 'administrative_area_code' => 'BA'],
            ['code' => 'BR', 'administrative_area' => 'Ceará', 'administrative_area_code' => 'CE'],
            ['code' => 'BR', 'administrative_area' => 'Distrito Federal', 'administrative_area_code' => 'DF'],
            ['code' => 'BR', 'administrative_area' => 'Espírito Santo', 'administrative_area_code' => 'ES'],
            ['code' => 'BR', 'administrative_area' => 'Goiás', 'administrative_area_code' => 'GO'],
            ['code' => 'BR', 'administrative_area' => 'Maranhão', 'administrative_area_code' => 'MA'],
            ['code' => 'BR', 'administrative_area' => 'Mato Grosso', 'administrative_area_code' => 'MT'],
            ['code' => 'BR', 'administrative_area' => 'Mato Grosso do Sul', 'administrative_area_code' => 'MS'],
            ['code' => 'BR', 'administrative_area' => 'Minas Gerais', 'administrative_area_code' => 'MG'],
            ['code' => 'BR', 'administrative_area' => 'Pará', 'administrative_area_code' => 'PA'],
            ['code' => 'BR', 'administrative_area' => 'Paraíba', 'administrative_area_code' => 'PB'],
            ['code' => 'BR', 'administrative_area' => 'Paraná', 'administrative_area_code' => 'PR'],
            ['code' => 'BR', 'administrative_area' => 'Pernambuco', 'administrative_area_code' => 'PE'],
            ['code' => 'BR', 'administrative_area' => 'Piauí', 'administrative_area_code' => 'PI'],
            ['code' => 'BR', 'administrative_area' => 'Rio de Janeiro', 'administrative_area_code' => 'RJ'],
            ['code' => 'BR', 'administrative_area' => 'Rio Grande do Norte', 'administrative_area_code' => 'RN'],
            ['code' => 'BR', 'administrative_area' => 'Rio Grande do Sul', 'administrative_area_code' => 'RS'],
            ['code' => 'BR', 'administrative_area' => 'Rondônia', 'administrative_area_code' => 'RO'],
            ['code' => 'BR', 'administrative_area' => 'Roraima', 'administrative_area_code' => 'RR'],
            ['code' => 'BR', 'administrative_area' => 'Santa Catarina', 'administrative_area_code' => 'SC'],
            ['code' => 'BR', 'administrative_area' => 'São Paulo', 'administrative_area_code' => 'SP'],
            ['code' => 'BR', 'administrative_area' => 'Sergipe', 'administrative_area_code' => 'SE'],
            ['code' => 'BR', 'administrative_area' => 'Tocantins', 'administrative_area_code' => 'TO'],
            // Argentina (AR)
            ['code' => 'AR', 'administrative_area' => 'Buenos Aires', 'administrative_area_code' => 'B'],
            ['code' => 'AR', 'administrative_area' => 'Catamarca', 'administrative_area_code' => 'K'],
            ['code' => 'AR', 'administrative_area' => 'Chaco', 'administrative_area_code' => 'H'],
            ['code' => 'AR', 'administrative_area' => 'Chubut', 'administrative_area_code' => 'U'],
            ['code' => 'AR', 'administrative_area' => 'Córdoba', 'administrative_area_code' => 'X'],
            ['code' => 'AR', 'administrative_area' => 'Corrientes', 'administrative_area_code' => 'W'],
            ['code' => 'AR', 'administrative_area' => 'Entre Ríos', 'administrative_area_code' => 'E'],
            ['code' => 'AR', 'administrative_area' => 'Formosa', 'administrative_area_code' => 'P'],
            ['code' => 'AR', 'administrative_area' => 'Jujuy', 'administrative_area_code' => 'Y'],
            ['code' => 'AR', 'administrative_area' => 'La Pampa', 'administrative_area_code' => 'L'],
            ['code' => 'AR', 'administrative_area' => 'La Rioja', 'administrative_area_code' => 'F'],
            ['code' => 'AR', 'administrative_area' => 'Mendoza', 'administrative_area_code' => 'M'],
            ['code' => 'AR', 'administrative_area' => 'Misiones', 'administrative_area_code' => 'N'],
            ['code' => 'AR', 'administrative_area' => 'Neuquén', 'administrative_area_code' => 'Q'],
            ['code' => 'AR', 'administrative_area' => 'Río Negro', 'administrative_area_code' => 'R'],
            ['code' => 'AR', 'administrative_area' => 'Salta', 'administrative_area_code' => 'A'],
            ['code' => 'AR', 'administrative_area' => 'San Juan', 'administrative_area_code' => 'J'],
            ['code' => 'AR', 'administrative_area' => 'San Luis', 'administrative_area_code' => 'D'],
            ['code' => 'AR', 'administrative_area' => 'Santa Cruz', 'administrative_area_code' => 'Z'],
            ['code' => 'AR', 'administrative_area' => 'Santa Fe', 'administrative_area_code' => 'S'],
            ['code' => 'AR', 'administrative_area' => 'Santiago del Estero', 'administrative_area_code' => 'G'],
            ['code' => 'AR', 'administrative_area' => 'Tierra del Fuego', 'administrative_area_code' => 'V'],
            ['code' => 'AR', 'administrative_area' => 'Tucumán', 'administrative_area_code' => 'T'],
            // United Kingdom (GB)
            ['code' => 'GB', 'administrative_area' => 'England', 'administrative_area_code' => 'ENG'],
            ['code' => 'GB', 'administrative_area' => 'Scotland', 'administrative_area_code' => 'SCT'],
            ['code' => 'GB', 'administrative_area' => 'Wales', 'administrative_area_code' => 'WLS'],
            ['code' => 'GB', 'administrative_area' => 'Northern Ireland', 'administrative_area_code' => 'NIR'],
            // Germany (DE)
            ['code' => 'DE', 'administrative_area' => 'Baden-Württemberg', 'administrative_area_code' => 'BW'],
            ['code' => 'DE', 'administrative_area' => 'Bavaria', 'administrative_area_code' => 'BY'],
            ['code' => 'DE', 'administrative_area' => 'Berlin', 'administrative_area_code' => 'BE'],
            ['code' => 'DE', 'administrative_area' => 'Brandenburg', 'administrative_area_code' => 'BB'],
            ['code' => 'DE', 'administrative_area' => 'Bremen', 'administrative_area_code' => 'HB'],
            ['code' => 'DE', 'administrative_area' => 'Hamburg', 'administrative_area_code' => 'HH'],
            ['code' => 'DE', 'administrative_area' => 'Hesse', 'administrative_area_code' => 'HE'],
            ['code' => 'DE', 'administrative_area' => 'Lower Saxony', 'administrative_area_code' => 'NI'],
            ['code' => 'DE', 'administrative_area' => 'Mecklenburg-Vorpommern', 'administrative_area_code' => 'MV'],
            ['code' => 'DE', 'administrative_area' => 'North Rhine-Westphalia', 'administrative_area_code' => 'NW'],
            ['code' => 'DE', 'administrative_area' => 'Rhineland-Palatinate', 'administrative_area_code' => 'RP'],
            ['code' => 'DE', 'administrative_area' => 'Saarland', 'administrative_area_code' => 'SL'],
            ['code' => 'DE', 'administrative_area' => 'Saxony', 'administrative_area_code' => 'SN'],
            ['code' => 'DE', 'administrative_area' => 'Saxony-Anhalt', 'administrative_area_code' => 'ST'],
            ['code' => 'DE', 'administrative_area' => 'Schleswig-Holstein', 'administrative_area_code' => 'SH'],
            ['code' => 'DE', 'administrative_area' => 'Thuringia', 'administrative_area_code' => 'TH'],
            // France (FR)
            ['code' => 'FR', 'administrative_area' => 'Auvergne-Rhône-Alpes', 'administrative_area_code' => 'ARA'],
            ['code' => 'FR', 'administrative_area' => 'Bourgogne-Franche-Comté', 'administrative_area_code' => 'BFC'],
            ['code' => 'FR', 'administrative_area' => 'Brittany', 'administrative_area_code' => 'BRE'],
            ['code' => 'FR', 'administrative_area' => 'Centre-Val de Loire', 'administrative_area_code' => 'CVL'],
            ['code' => 'FR', 'administrative_area' => 'Corsica', 'administrative_area_code' => 'COR'],
            ['code' => 'FR', 'administrative_area' => 'Grand Est', 'administrative_area_code' => 'GES'],
            ['code' => 'FR', 'administrative_area' => 'Hauts-de-France', 'administrative_area_code' => 'HDF'],
            ['code' => 'FR', 'administrative_area' => 'Île-de-France', 'administrative_area_code' => 'IDF'],
            ['code' => 'FR', 'administrative_area' => 'Normandy', 'administrative_area_code' => 'NOR'],
            ['code' => 'FR', 'administrative_area' => 'Nouvelle-Aquitaine', 'administrative_area_code' => 'NAQ'],
            ['code' => 'FR', 'administrative_area' => 'Occitanie', 'administrative_area_code' => 'OCC'],
            ['code' => 'FR', 'administrative_area' => 'Pays de la Loire', 'administrative_area_code' => 'PDL'],
            ['code' => 'FR', 'administrative_area' => 'Provence-Alpes-Côte d\'Azur', 'administrative_area_code' => 'PAC'],
            // Italy (IT)
            ['code' => 'IT', 'administrative_area' => 'Abruzzo', 'administrative_area_code' => '65'],
            ['code' => 'IT', 'administrative_area' => 'Aosta Valley', 'administrative_area_code' => '23'],
            ['code' => 'IT', 'administrative_area' => 'Apulia', 'administrative_area_code' => '75'],
            ['code' => 'IT', 'administrative_area' => 'Basilicata', 'administrative_area_code' => '77'],
            ['code' => 'IT', 'administrative_area' => 'Calabria', 'administrative_area_code' => '78'],
            ['code' => 'IT', 'administrative_area' => 'Campania', 'administrative_area_code' => '72'],
            ['code' => 'IT', 'administrative_area' => 'Emilia-Romagna', 'administrative_area_code' => '45'],
            ['code' => 'IT', 'administrative_area' => 'Friuli Venezia Giulia', 'administrative_area_code' => '36'],
            ['code' => 'IT', 'administrative_area' => 'Lazio', 'administrative_area_code' => '62'],
            ['code' => 'IT', 'administrative_area' => 'Liguria', 'administrative_area_code' => '42'],
            ['code' => 'IT', 'administrative_area' => 'Lombardy', 'administrative_area_code' => '25'],
            ['code' => 'IT', 'administrative_area' => 'Marche', 'administrative_area_code' => '57'],
            ['code' => 'IT', 'administrative_area' => 'Molise', 'administrative_area_code' => '67'],
            ['code' => 'IT', 'administrative_area' => 'Piedmont', 'administrative_area_code' => '21'],
            ['code' => 'IT', 'administrative_area' => 'Sardinia', 'administrative_area_code' => '88'],
            ['code' => 'IT', 'administrative_area' => 'Sicily', 'administrative_area_code' => '82'],
            ['code' => 'IT', 'administrative_area' => 'Trentino-Alto Adige', 'administrative_area_code' => '32'],
            ['code' => 'IT', 'administrative_area' => 'Tuscany', 'administrative_area_code' => '52'],
            ['code' => 'IT', 'administrative_area' => 'Umbria', 'administrative_area_code' => '55'],
            ['code' => 'IT', 'administrative_area' => 'Veneto', 'administrative_area_code' => '34'],
            // Russia (RU)
            ['code' => 'RU', 'administrative_area' => 'Moscow', 'administrative_area_code' => 'MOW'],
            ['code' => 'RU', 'administrative_area' => 'Saint Petersburg', 'administrative_area_code' => 'SPE'],
            ['code' => 'RU', 'administrative_area' => 'Novosibirsk Oblast', 'administrative_area_code' => 'NVS'],
            ['code' => 'RU', 'administrative_area' => 'Krasnodar Krai', 'administrative_area_code' => 'KDA'],
            ['code' => 'RU', 'administrative_area' => 'Sverdlovsk Oblast', 'administrative_area_code' => 'SVE'],
            // Turkey (TR)
            ['code' => 'TR', 'administrative_area' => 'Ankara', 'administrative_area_code' => '06'],
            ['code' => 'TR', 'administrative_area' => 'Istanbul', 'administrative_area_code' => '34'],
            ['code' => 'TR', 'administrative_area' => 'Izmir', 'administrative_area_code' => '35'],
            // Saudi Arabia (SA)
            ['code' => 'SA', 'administrative_area' => 'Riyadh', 'administrative_area_code' => '01'],
            ['code' => 'SA', 'administrative_area' => 'Makkah', 'administrative_area_code' => '02'],
            ['code' => 'SA', 'administrative_area' => 'Eastern Province', 'administrative_area_code' => '04'],
            // South Africa (ZA)
            ['code' => 'ZA', 'administrative_area' => 'Gauteng', 'administrative_area_code' => 'GP'],
            ['code' => 'ZA', 'administrative_area' => 'Western Cape', 'administrative_area_code' => 'WC'],
            ['code' => 'ZA', 'administrative_area' => 'KwaZulu-Natal', 'administrative_area_code' => 'KZN'],
            // India (IN)
            ['code' => 'IN', 'administrative_area' => 'Andhra Pradesh', 'administrative_area_code' => 'AP'],
            ['code' => 'IN', 'administrative_area' => 'Arunachal Pradesh', 'administrative_area_code' => 'AR'],
            ['code' => 'IN', 'administrative_area' => 'Assam', 'administrative_area_code' => 'AS'],
            ['code' => 'IN', 'administrative_area' => 'Bihar', 'administrative_area_code' => 'BR'],
            ['code' => 'IN', 'administrative_area' => 'Chhattisgarh', 'administrative_area_code' => 'CT'],
            ['code' => 'IN', 'administrative_area' => 'Goa', 'administrative_area_code' => 'GA'],
            ['code' => 'IN', 'administrative_area' => 'Gujarat', 'administrative_area_code' => 'GJ'],
            ['code' => 'IN', 'administrative_area' => 'Haryana', 'administrative_area_code' => 'HR'],
            ['code' => 'IN', 'administrative_area' => 'Himachal Pradesh', 'administrative_area_code' => 'HP'],
            ['code' => 'IN', 'administrative_area' => 'Jharkhand', 'administrative_area_code' => 'JH'],
            ['code' => 'IN', 'administrative_area' => 'Karnataka', 'administrative_area_code' => 'KA'],
            ['code' => 'IN', 'administrative_area' => 'Kerala', 'administrative_area_code' => 'KL'],
            ['code' => 'IN', 'administrative_area' => 'Madhya Pradesh', 'administrative_area_code' => 'MP'],
            ['code' => 'IN', 'administrative_area' => 'Maharashtra', 'administrative_area_code' => 'MH'],
            ['code' => 'IN', 'administrative_area' => 'Manipur', 'administrative_area_code' => 'MN'],
            ['code' => 'IN', 'administrative_area' => 'Meghalaya', 'administrative_area_code' => 'ML'],
            ['code' => 'IN', 'administrative_area' => 'Mizoram', 'administrative_area_code' => 'MZ'],
            ['code' => 'IN', 'administrative_area' => 'Nagaland', 'administrative_area_code' => 'NL'],
            ['code' => 'IN', 'administrative_area' => 'Odisha', 'administrative_area_code' => 'OR'],
            ['code' => 'IN', 'administrative_area' => 'Punjab', 'administrative_area_code' => 'PB'],
            ['code' => 'IN', 'administrative_area' => 'Rajasthan', 'administrative_area_code' => 'RJ'],
            ['code' => 'IN', 'administrative_area' => 'Sikkim', 'administrative_area_code' => 'SK'],
            ['code' => 'IN', 'administrative_area' => 'Tamil Nadu', 'administrative_area_code' => 'TN'],
            ['code' => 'IN', 'administrative_area' => 'Telangana', 'administrative_area_code' => 'TG'],
            ['code' => 'IN', 'administrative_area' => 'Tripura', 'administrative_area_code' => 'TR'],
            ['code' => 'IN', 'administrative_area' => 'Uttar Pradesh', 'administrative_area_code' => 'UP'],
            ['code' => 'IN', 'administrative_area' => 'Uttarakhand', 'administrative_area_code' => 'UT'],
            ['code' => 'IN', 'administrative_area' => 'West Bengal', 'administrative_area_code' => 'WB'],
            // China (CN)
            ['code' => 'CN', 'administrative_area' => 'Beijing', 'administrative_area_code' => 'BJ'],
            ['code' => 'CN', 'administrative_area' => 'Shanghai', 'administrative_area_code' => 'SH'],
            ['code' => 'CN', 'administrative_area' => 'Guangdong', 'administrative_area_code' => 'GD'],
            ['code' => 'CN', 'administrative_area' => 'Sichuan', 'administrative_area_code' => 'SC'],
            ['code' => 'CN', 'administrative_area' => 'Yunnan', 'administrative_area_code' => 'YN'],
            // Japan (JP)
            ['code' => 'JP', 'administrative_area' => 'Tokyo', 'administrative_area_code' => '13'],
            ['code' => 'JP', 'administrative_area' => 'Osaka', 'administrative_area_code' => '27'],
            ['code' => 'JP', 'administrative_area' => 'Hokkaido', 'administrative_area_code' => '01'],
            ['code' => 'JP', 'administrative_area' => 'Aichi', 'administrative_area_code' => '23'],
            // South Korea (KR)
            ['code' => 'KR', 'administrative_area' => 'Seoul', 'administrative_area_code' => '11'],
            ['code' => 'KR', 'administrative_area' => 'Busan', 'administrative_area_code' => '26'],
            ['code' => 'KR', 'administrative_area' => 'Incheon', 'administrative_area_code' => '28'],
            // Australia (AU)
            ['code' => 'AU', 'administrative_area' => 'New South Wales', 'administrative_area_code' => 'NSW'],
            ['code' => 'AU', 'administrative_area' => 'Victoria', 'administrative_area_code' => 'VIC'],
            ['code' => 'AU', 'administrative_area' => 'Queensland', 'administrative_area_code' => 'QLD'],
            ['code' => 'AU', 'administrative_area' => 'Western Australia', 'administrative_area_code' => 'WA'],
            ['code' => 'AU', 'administrative_area' => 'South Australia', 'administrative_area_code' => 'SA'],
            ['code' => 'AU', 'administrative_area' => 'Tasmania', 'administrative_area_code' => 'TAS'],
            ['code' => 'AU', 'administrative_area' => 'Australian Capital Territory', 'administrative_area_code' => 'ACT'],
            ['code' => 'AU', 'administrative_area' => 'Northern Territory', 'administrative_area_code' => 'NT'],
            // Indonesia (ID)
            ['code' => 'ID', 'administrative_area' => 'Jakarta', 'administrative_area_code' => 'JK'],
            ['code' => 'ID', 'administrative_area' => 'West Java', 'administrative_area_code' => 'JB'],
            ['code' => 'ID', 'administrative_area' => 'Central Java', 'administrative_area_code' => 'JT'],
            ['code' => 'ID', 'administrative_area' => 'East Java', 'administrative_area_code' => 'JI'],
            ['code' => 'ID', 'administrative_area' => 'Bali', 'administrative_area_code' => 'BA'],
        ];

        // Get country_id for each country_code
            $countryIds = DB::table('countries')->pluck('id', 'code')->toArray();
            $now = now();
            $rows = [];
            foreach ($administrativeAreas as $area) {
                $country_id = $countryIds[$area['code']] ?? null;
                if ($country_id) {
                    $rows[] = [
                        'uuid' => Str::uuid()->toString(),
                        'country_id' => $country_id,
                        'name' => $area['administrative_area'],
                        'code' => $area['administrative_area_code'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }
            if ($rows) {
                // Use insert for SQLite, fallback if upsert fails
                try {
                    DB::table('administrative_areas')->upsert(
                        $rows,
                        ['country_id', 'code'],
                        ['name', 'updated_at']
                    );
                } catch (\Exception $e) {
                    // Fallback for SQLite: insert or ignore, then update
                    foreach ($rows as $row) {
                        DB::table('administrative_areas')->updateOrInsert(
                            [
                                'country_id' => $row['country_id'],
                                'code' => $row['code'],
                            ],
                            $row
                        );
                    }
                }
            }
    }
}
