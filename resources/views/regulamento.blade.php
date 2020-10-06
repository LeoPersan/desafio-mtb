@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 py-5">
            <div class="container">
                <h1>
                    <a href="{{ asset('Regulamento MTB Termo de Autorizacao.pdf') }}" target="_blank">Regulamento</a>
                </h1>
            </div>
        </div>
        <div class="col-12 py-5 black">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>1 - Sobre o Desafio</h2>
                        <p>
                            O 2º Desafio MTB Rotaract Club de Tupi Paulista é aberto a qualquer ciclista, de ambos os sexos,
                            que deseje superar seus limites.
                        </p>
                        <p>
                            Inovando e adequando a prova à realidade atual, onde a pandemia da COVID-19 não nos permite
                            realizar provas presenciais, o Desafio motiva os atletas a não ficarem parados nesse período.
                        </p>
                        <p>
                            O objetivo é incentivar cada atleta a concluir seu percurso com êxito durante o mês de novembro
                            de 2020.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>2 - Inscrição</h2>
                        <p>
                            2.1 - As inscrições deverão ser realizadas pela internet através do site
                            http://desafiomtb.rotaracttupipaulista.org.br/. A partir das 10h00min do dia 12 de setembro de
                            2020.
                        </p>
                        <p>
                            2.2 – O pagamento das inscrições poderá ser efetuado via boleto ou cartão de crédito.
                        </p>
                        <p>
                            2.3 – As inscrições com pagamento via boleto encerram-se às 23h59min do dia 22 de outubro de
                            2020, já as inscrições com pagamento via cartão de crédito podem ser realizadas até às 23h00min
                            do dia 31 de outubro de 2020.
                        </p>
                        <p>
                            2.4 - O custo da inscrição é de R$80,00 (oitenta reais), acrescido de eventuais taxas da
                            operadora de cartão e do PagSeguro, estando incluso camiseta oficial do evento, certificado de
                            participação e medalha. Caso o atleta não deseje adquirir a inscrição com camiseta o custo será
                            de R$40,00 (quarenta reais) mais taxas da operadora de cartão e do PagSeguro e terá direito a
                            certificado de participação e medalha.
                        </p>
                        <p>
                            2.5 – As despesas com envio dos Kits ficarão por conta do atleta. Os Kits serão enviados após o
                            término da prova, com prazo máximo de envio até 12 de dezembro de 2020.
                        </p>
                        <p>
                            2.6 - A organização divulgará, posteriormente, data, local e horário para retirada dos kits
                            pessoalmente por aqueles que escolherem essa opção.
                        </p>
                        <p>
                            2.7- Não será permitida a transferência de inscrição entre os atletas.
                        </p>
                        <p>
                            2.8 – A inscrição é de inteira responsabilidade do atleta, que deve verificar o Kit escolhido e
                            Kms que pretende pedalar. Caso deseje alterar o percurso escolhido contatar a organização
                            através do e-mail rcttupipta@gmail.com. A alteração poderá ser realizada até às 17h00min do dia
                            30 de outubro 2020.
                        </p>
                        <p>
                            2.9 – O inscrito tem o prazo de 7 (sete) dias corridos após a data da compra para solicitar o
                            cancelamento e estorno do valor da inscrição. A solicitação deve ser feita através do e-mail
                            rcttupipta@gmail.com. O valor da inscrição assim como o valor da taxa do site, não serão
                            devolvidos após esse prazo.
                        </p>
                        <p>
                            2.10 - Ao realizar sua inscrição no Desafio o participante autoriza o uso da sua imagem em
                            publicações nas redes sociais referentes ao Desafio.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 black">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>3 - Participantes</h2>
                        <p>
                            3.1 - Poderão se inscrever para o desafio atletas de ambos o sexos a partir de 13 anos de idade
                            completos até a data da inscrição.
                        </p>
                        <p>
                            3.2 - Para ter sua inscrição validada, o atleta menor deve enviar para a organização, através do
                            e-mail rcttupipta@gmail.com, termo de autorização assinado por seus pais ou responsáveis.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>4 – O Percurso</h2>
                        <p>
                            4.1 – Ao realizar sua inscrição o atleta deve optar por um dos seguintes percursos:
                        </p>
                        <p>
                            a) 3000 km (três mil quilômetros);
                        </p>
                        <p>
                            b) 2000 km (dois mil quilômetros);
                        </p>
                        <p>
                            c) 1000 km (mil quilômetros);
                        </p>
                        <p>
                            d) 500 km (quinhentos quilômetros);
                        </p>
                        <p>
                            e) 200 km (duzentos quilômetros).
                        </p>
                        <p>
                            3.2 – O trajeto poderá ser realizado em qualquer tipo de terreno com ou sem pavimento e em
                            locais e rotas de livre escolha do participante.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 black">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>5 - O Desafio</h2>
                        <p>
                            5.1 – O Desafio deverá ser realizado a partir das 00h00 do dia 01 de novembro de 2020 até 23h59
                            do dia 30 de novembro de 2020.
                        </p>
                        <p>
                            5.2 – A monitoração do desafio será realizada “somente” pelo Aplicativo STRAVA. A classificação
                            dos atletas será realizada através da soma do ganho de elevação dos trajetos percorridos durante
                            o período de prova.
                        </p>
                        <p>
                            5.3 - Ao realizar sua inscrição o atleta deve fornecer endereço de e-mail, válido, onde receberá
                            um link que autorizará a organização ter acesso às atividades realizadas pelo atleta durante o
                            período de prova.
                        </p>
                        <p>
                            5.4 - Todas as atividades realizadas serão disponibilizadas na Área do Atleta, onde o ciclista
                            poderá indicar quais são as atividades que deseja utilizar para o cálculo de ganho de elevação.
                            A indicação das atividades deve ser realizada até 23:59 do dia 30 de novembro de 2020.
                        </p>
                        <p>
                            5.5 - Para fins de cálculo do ganho de elevação, a soma da quilometragem das atividades
                            indicadas poderá exceder a quilometragem do percurso para o qual o ciclista se inscreveu em 20km
                            somente.
                        </p>
                        <p>
                            5.6 - O participante poderá realizar quantas atividades julgar necessárias durante o período de
                            prova para completar seu percurso, sendo aceita a indicação de apenas uma atividade por dia.
                        </p>
                        <p>
                            5.7 - O tipo de atividade tem que ser “PEDALADA”, não serão aceitas pedalada virtual, bicicleta
                            elétrica, rolo ou marcação manual, sob pena de ser descartada.
                        </p>
                        <p>
                            5.8 - Pode ser utilizado qualquer tipo de bicicleta, sendo requerido somente que seja movida
                            exclusivamente pela força humana. Motores ou outros meios de propulsão mecânicos ou elétricos
                            não serão permitidos.
                        </p>
                        <p>
                            5.9 - Qualquer irregularidade identificada pela organização no registro das atividades, tais
                            como medidas “anormais” em velocidade compatível a uma bike, será revisada e a(s) atividade(s)
                            poderá(ão) ser descartadas.
                        </p>
                        <p>
                            5.10 – Não serão aceitas interpelações do tipo “meu STRAVA não marcou, mas fulano é testemunha,
                            fiz com ele”, “minha bateria descarregou”, “meu STRAVA deu retas, mas fiz corretamente”, entre
                            outras do mesmo gênero devido erros ocasionados pelo aparelho ou dispositivo, bem como pelo
                            software. A organização não se responsabilizará pelo funcionamento do aparelho ou software.
                        </p>
                        <p>
                            5.11 – O resultado da prova será divulgado até dia 12 de dezembro.
                        </p>
                        <p>
                            5.12 – Todos os atletas receberão certificado ao término da prova. Aos atletas que não
                            concluírem o percurso será enviado certificado de PARTICIPAÇÃO apenas, já aos atletas que
                            concluírem a prova será enviado certificado constando a quilometragem escolhida e informando sua
                            CONCLUSÃO.
                        </p>
                        <p>
                            5.13 - Os certificados, PARTICIPAÇÃO ou CONCLUSÃO, serão enviados em formato digital (arquivo
                            jpg), através do e-mail informado pelo atleta no ato de sua inscrição.
                        </p>
                        <p>
                            5.14 - Para fins de motivação, semanalmente será divulgado o ranking provisório dos atletas com
                            base nas atividades registradas e por eles selecionadas na Área do Atleta. Caso o atleta não
                            deseje ter seu desempenho divulgado no ranking semanal basta não indicar atividade na área do
                            atleta.
                        </p>
                        <p>
                            5.15 - A atividade deve ser executada pelo próprio atleta e deve ser monitorada e sincronizada
                            em modo PÚBLICO via Aplicativo STRAVA. Não serão aceitas, em hipótese alguma, atividades de
                            terceiros onde o atleta foi marcado.
                        </p>
                        <p>
                            5.16 - O cálculo para fins de ranqueamento, tanto o semanal (provisório) quanto o final, será
                            realizado através de aplicativo desenvolvido especificamente para esta finalidade. O atleta
                            poderá visualizar seu resultado individual na área do atleta.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 bg-white">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>6 - Premiação</h2>
                        <p>
                            6.1 - Todos os inscritos receberão medalha, independentemente da conclusão ou não do percurso,
                            ficando o custo de envio por conta do atleta.
                        </p>
                        <p>
                            6.2 – O primeiro colocado de cada percurso, tanto a categoria masculina (Rei da Montanha) quanto
                            a feminina (Rainha da Montanha), receberá troféu como premiação. A despesa do envio será por
                            conta da organização.
                        </p>
                        <p>
                            6.3 - Aqueles que não completarem a prova não terão, em hipótese nenhuma, direito ao
                            ressarcimento dos valores pagos pela inscrição.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 py-5 black">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h2>7 - Responsabilidade do Participante</h2>
                        <p>
                            7.1 - Saúde física e mental é de responsabilidade do atleta. Sugerimos um Check-Up médico antes
                            do início do Desafio.
                        </p>
                        <p>
                            7.2 - Manutenção da bicicleta é de total responsabilidade do atleta.
                        </p>
                        <p>
                            7.3 - Não haverá reembolso, por parte da Organização, bem como seus patrocinadores, apoiadores e
                            realizadores de nenhum valor correspondente a equipamentos e/ou acessórios utilizados pelos
                            participantes no evento, independentemente de qual for o motivo, nem por qualquer extravio de
                            materiais ou prejuízo que por ventura os participantes venham a sofrer durante a participação do
                            evento.
                        </p>
                        <p>
                            7.4 - A Organização, bem como seus patrocinadores, apoiadores e realizadores não se
                            responsabilizam por prejuízos ou danos causados pelo participante inscrito no evento, seja ao
                            patrimônio público, a terceiros ou outros participantes, sendo esses de única e exclusiva
                            responsabilidade do causador do dano.
                        </p>
                        <p>
                            7.5 - O Participante assume que participa deste evento por livre e espontânea vontade, isentando
                            de qualquer responsabilidade os organizadores, realizadores, patrocinadores e apoiadores em seu
                            nome e de seus sucessores.
                        </p>
                        <p>
                            7.6 – Ao realizar sua inscrição o atleta concorda com todos os termos deste regulamento bem como
                            declara estar ciente de todas as responsabilidades elencadas neste item 7.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
