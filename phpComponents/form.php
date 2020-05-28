<form method="get" action="" class="main-form needs-validation" id="mainForm" novalidate>
    <div class="form-group">
        <label for="my-input">Email</label>
        <input type="email" class="form-control form-control-sm" id="emailVal" name="emailVal" required>
    </div>
    <div class="form-group">
        <label for="my-input" id="nameLabel">Nome</label>
        <input type="text" class="form-control  form-control-sm" id="nomeVal" name="nomeVal" required>
    </div>
    <!------FORM ROW DNASCIMENTO LOCALIDADE NIF-->
    <div class="form-row noLogIn">
        <div class="form-group col-md-4">
            <label for="inputEmail4">Data Nascimento</label>
            <input type="date" class="form-control form-control-sm" name="dataNascimentoVal" id="birthDate" min="1904-01-01" max="2025-12-12">
        </div>
        <div class="form-group col-md-4">
            <label for="Localidade">Distrito</label>
            <select name="localidadeVal" id="LocalidadeVal" class="form-control form-control-sm">
                <option selected value="Aveiro">Aveiro</option>
                <option value="Beja">Beja</option>
                <option value="Braga">Braga</option>
                <option value="Bragança">Bragança</option>
                <option value="Castelo Branco">Castelo Branco</option>
                <option value="Coimbra">Coimbra</option>
                <option value="Évora">Évora</option>
                <option value="Faro">Faro</option>
                <option value="Guarda">Guarda</option>
                <option value="Leiria">Leiria</option>
                <option value="Lisboa">Lisboa</option>
                <option value="Portalegre">Portalegre</option>
                <option value="Porto">Porto</option>
                <option value="Santarém">Santarém</option>
                <option value="Setúbal">Setúbal</option>
                <option value="Viana do Castelo">Viana do Castelo</option>
                <option value="Vila Real">Vila Real</option>
                <option value="Viseu">Viseu</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="NIF">NIF</label>
            <input name="nifVal" type="number" class="form-control form-control-sm" id="nifVal">
        </div>
    </div>

    <!-- Form Row Numero de telemovel Club-->
    <div class="form-row noLogIn">
        <div class="form-group col-md-6">
            <label for="inputEmail4">Telémovel</label>
            <input id="telInput" name="telemovelVal" type="text"  maxlength="9"  max="9" pattern="[0-9]*" class="form-control form-control-sm">
        </div>
        <div class="form-group col-md-6">
            <label for="club">Clube</label>
            <select name="clubVal" id="clubVal" class="form-control form-control-sm">
                <option selected value="Belenenses SAD">Belenenses SAD</option>
                <option value="Boavista Futebol Clube">Boavista Futebol Clube</option>
                <option value="Club Sport Marítimo">Club Sport Marítimo</option>
                <option value="Clube Desportivo das Aves">Clube Desportivo das Aves</option>
                <option value="Clube Desportivo Santa Clara">Clube Desportivo Santa Clara</option>
                <option value="Clube Desportivo Tondela">Clube Desportivo Tondela</option>
                <option value="FC Famalicão">FC Famalicão</option>
                <option value="FC Paços de Ferreira">FC Paços de Ferreira</option>
                <option value="Futebol Clube do Porto">Futebol Clube do Porto</option>
                <option value="Gil Vicente Futebol Clube">Gil Vicente Futebol Clube</option>
                <option value="Moreirense Futebol Clube">Moreirense Futebol Clube</option>
                <option value="Portimonense Sporting Clube">Portimonense Sporting Clube</option>
                <option value="Rio Ave Futebol Clube">Rio Ave Futebol Clube</option>
                <option value="Sport Lisboa e Benfica">Sport Lisboa e Benfica</option>
                <option value="Sporting Clube de Braga">Sporting Clube de Braga</option>
                <option value="Sporting Clube de Portugal">Sporting Clube de Portugal</option>
                <option value="Vitória Futebol Clube">Vitória Futebol Clube</option>
                <option value="Vitória Sport Clube">Vitória Sport Clube</option>
            </select>
        </div>
    </div>

    <!--Check Boxes section-->
    <div class="row noLogIn">
        <div class="col">
        <p id="qualClubParagrafo">Quais os seguros que possui atualmente?</p>
        </div>
    </div>
 
    <div class="row noLogIn">
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="autoVal" value="true">
                <label for="my-input" class="form-check-label">Auto</label>
            </div>
        </div>
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="vidaVal" value="1">
                <label for="my-input" class="form-check-label">Vida</label>
            </div>
        </div>
    </div>
    <div class="row noLogIn">
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="saudeVal" value="1">
                <label for="my-input" class="form-check-label">Saúde</label>
            </div>
        </div>
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="casaVal" value="1">
                <label for="my-input" class="form-check-label">Casa</label>
            </div>
        </div>
    </div>
    <div class="row noLogIn">
        <div class="col">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="outroVal" value="1">
                <label for="my-input" class="form-check-label">Outro</label>
            </div>
        </div>
    </div>

    <div class="AceitoDados">
        <div class="form-check">
            <input id="direitoInfo" class="form-check-input" type="checkbox" name="direitoInfoVal" value="1">
            <label for="my-input" class="form-check-label"><a href="https://celebramosfutebol.sabseg.com/resources/files/CelebramosFutebol_DireitoInformacao.pdf">Li e compreendi o direito de informação</a></label>
        </div>
        <div class="form-check">
            <input id="termosInfo" class="form-check-input" type="checkbox" name="" value="1">
            <label for="my-input" class="form-check-label"> Autorizo a consulta e a utilização dos dados pessoais disponibilizados, sob regime de absoluta confidencialidade, à SABSEG designadamente para o envio de futuras campanhas de marketing, de publicidade e de informação sobre produtos e serviços.</label>
        </div>
    </div>

    <div class="text-center pb-2">
        <button type="submit" class="btn btn-primary basicBtn" id="enviarFormBtn">Login</button>
    </div>

</form>

<?php include 'phpComponents/phpErroToast.php' ?>