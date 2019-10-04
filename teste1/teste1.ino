//Includes
//RTC
#include <freertos/FreeRTOS.h>
#include <freertos/task.h>
#include <esp_system.h>
#include <time.h>
#include <sys/time.h>
//WIFI e NPT
#include <WiFi.h>
#include <WiFiUdp.h>
#include <NTPClient.h>
#include <WiFiMulti.h>
#include <HTTPClient.h>


#include <Wire.h>
WiFiMulti wifiMulti;
//Variavel que controla a quantidade
int quantidade=0;
long horarios[32];
int posicao=0;
struct tm data;//Cria a estrutura que contem as informacoes da data.
 
// Configurações do WiFi
const char* ssid     = "DESKTOP-MY";
const char* password = "12345678";
 
// Configurações do Servidor NTP
const char* servidorNTP = "a.st1.ntp.br"; // Servidor NTP para pesquisar a hora
 
const int fusoHorario = -10800; // Fuso horário em segundos (-03h = -10800 seg)
const int taxaDeAtualizacao = 1800000; // Taxa de atualização do servidor NTP em milisegundos
 
WiFiUDP ntpUDP; // Declaração do Protocolo UDP
NTPClient timeClient(ntpUDP, servidorNTP, fusoHorario, 60000);


 
void setup()
{  
    Serial.begin(115200);
    wifiMulti.addAP("DESKTOP-MY", "12345678");
    /*pegar banco de dados de horarios e inserir no vetor horarios
    requisicaoHTTP();
 
 
  //Iniciar cliente de aquisição do tempo
  //Inicia o servidor NTP
  timeClient.begin();
  //Atualiza o horario atravez do servidor NTP
  timeClient.update();

  
  timeval tv;//Cria a estrutura temporaria para funcao abaixo.
  tv.tv_sec = timeClient.getEpochTime();//Atribui minha data atual em formato Unix Timestamp, 
  settimeofday(&tv, NULL);//Configura o RTC para manter a data atribuida atualizada.
  //escolher no vetor de horarios
  definirPosicao();*/
}
  
void loop()
{
   if (Serial.available() > 0){
   String recebido = leStringSerial();
   requisicaoHTTP(recebido,"1234");
    Serial.println(recebido);
   } 
}
String leStringSerial(){
  String conteudo = "";
  char caractere;
  
  // Enquanto receber algo pela serial
  while(Serial.available() > 0) {
    // Lê byte da serial
    caractere = Serial.read();
    // Ignora caractere de quebra de linha
    if (caractere != '\n'){
      // Concatena valores
      if(caractere == '0' || caractere == '1' || caractere == '2'  || caractere == '3' || caractere == '4' || caractere == '5' || caractere == '6' || caractere == '7' || caractere == '8' || caractere == '9')
      conteudo.concat(caractere);
    }
    // Aguarda buffer serial ler próximo caractere
    delay(10);
  }
    
  Serial.println(conteudo);
    
  return conteudo;
}

void requisicaoHTTP(String cod,String sen){
  // wait for WiFi connection
    if((wifiMulti.run() == WL_CONNECTED)) {

        HTTPClient http;

        Serial.print("[HTTP] begin...\n");

        // configure server and url
       String url = "/RemoteLock/pegarHorarios.php?";
        url += "codigo=";
        url += cod;
        url += "&senha=";
        url += sen;
        http.begin("http://10.215.136.77"+url);
        //http.begin("192.168.1.12", 80, "/test.html");
        Serial.println("http://10.215.136.77");
        Serial.println(url);

        Serial.print("[HTTP] GET...\n");
        // start connection and send HTTP header
        int httpCode = http.GET();
        if(httpCode > 0) {
            // HTTP header has been send and Server response header has been handled
            Serial.printf("[HTTP] GET... code: %d\n", httpCode);

            // file found at server
            if(httpCode == HTTP_CODE_OK) {

                // get lenght of document (is -1 when Server sends no Content-Length header)
                int len = http.getSize();

                // create buffer for read
                char buff[128] = { 0 };

                // get tcp stream
                WiFiClient * stream = http.getStreamPtr();

                // read all data from server
                 Serial.println(http.connected());
                while(http.connected() && (len > 0 || len == -1)) {
                    // get available data size
                    size_t size = stream->available();

                    if(size) {
                        // read up to 128 byte
                        int c = stream->readBytes(buff, ((size > sizeof(buff)) ? sizeof(buff) : size));
                        // write it to Serial
                        String sc=buff;
                        if(sc.equals("true")){
                          Serial.println("Liberado");
                        }else{
                          Serial.println("Não liberado");
                        }
                        if(len > 0) {
                            len -= c;
                        }
                    }
                    delay(1);
                }
                 Serial.println(buff);
                Serial.print("[HTTP] connection closed or file end.\n");

            }
        } else {
            Serial.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
        }
        http.end();
    }else{
       Serial.printf("Sem Conexão");
    }

    delay(1000);
  }
  int definirPosicao(){
    time_t tt = time(NULL);
    int hour = (tt / 3600) % 24;
    int m = (tt / 60) % 60;
    long horaAtual = hour*3600+m*60;
    for(int i=0;i<quantidade;i++){
      if(horarios[i]>horaAtual){
        posicao=i;
        break;
      }else{
        posicao=i;
      }
    }
  }
  int proximaPosicao(){
  if(posicao==quantidade)
    posicao=0;
  else
    posicao+=1;
  }
  void quebrarHorarios(char* s,int c){
  String str(s);
  int i;
  int pos=0;
  for(i=0;i<str.length();i++){
    if(str.substring(i,i+1)=="@"){
      String quebra=str.substring(pos,i);
      int h=quebra.toInt();
      inserirHorario(h);
      pos=i+1;
    }
  }
   String quebra=str.substring(pos,i);
   long h=quebra.toInt();
   inserirHorario(h);
  }

  void inserirHorario(long horario){
    if(quantidade<32){
      horarios[quantidade]=horario;
      int i=quantidade;
      while(i > 0){
         i-=1;
        long horaAnterior=horarios[i];
        if(horario<horaAnterior){
          int aux=horarios[i+1];
          horarios[i+1]=horarios[i];
          horarios[i]=aux;
        }
       }
      quantidade++;
    }
    imprimir();
  }
void imprimir(){
Serial.print("Vetor de horarios- pos[");
Serial.print(posicao);
Serial.println("]");
for(int i=0;i<quantidade;i++){
  Serial.println(horarios[i]);
}
}
 void atualizarHoraRTCdoNTP(){
    timeval tv;//Cria a estrutura temporaria para funcao abaixo.
    tv.tv_sec = timeClient.getEpochTime();//Atribui minha data atual. Voce pode usar o NTP para isso ou o site citado no artigo!
    settimeofday(&tv, NULL);//Configura o RTC para manter a data atribuida atualizada.
 }
