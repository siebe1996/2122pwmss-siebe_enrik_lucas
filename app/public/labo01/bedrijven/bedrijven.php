<?php
/**
 * Lab 02, Exercise 2 — Start from this version
 * Companies
 * @author <your name>
 */

$companies = [['name' => 'Lunch Garden', 'address' => 'Avenue des Olympiades 2', 'zip' => 1140, 'city' => 'Bruxelles', 'activity' => 'Restaurants and mobile food service activities', 'vat' => 'BE0447668559'],
        ['name' => 'Randstad Belgium', 'address' => 'Avenue Charles-Quint 586/8', 'zip' => 1082, 'city' => 'Bruxelles', 'activity' => 'Specialised construction activities', 'vat' => 'BE0402725291'],
        ['name' => 'Seris Security', 'address' => 'Telecomlaan 8', 'zip' => 1831, 'city' => 'Diegem', 'activity' => 'Specialised construction activities', 'vat' => 'BE0404770607'],
        ['name' => 'VMW', 'address' => 'Vooruitgangstraat 189', 'zip' => 1030, 'city' => 'Brussel', 'activity' => 'Manufacture of metal structures and parts of structures', 'vat' => 'BE0224771467'],
        ['name' => 'Parfumerie Ici Paris XL', 'address' => 'Schaarbeeklei 499', 'zip' => 1800, 'city' => 'Vilvoorde', 'activity' => 'Retail sale of cosmetic and toilet articles in specialised stores', 'vat' => 'BE0413790518'],
        ['name' => 'Hewlett Packard Belgium', 'address' => 'Hermeslaan 1A', 'zip' => 1831, 'city' => 'Diegem', 'activity' => 'Electrical installation', 'vat' => 'BE0402220594'],
        ['name' => 'Proximus', 'address' => 'Boulevard du Roi Albert II 27', 'zip' => 1030, 'city' => 'Bruxelles', 'activity' => 'Construction of utility projects for electricity and telecommunications', 'vat' => 'BE0202239951'],
        ['name' => 'I.B.M. Belgium', 'address' => 'Avenue du Bourget 42', 'zip' => 1130, 'city' => 'Bruxelles', 'activity' => 'Electrical installation', 'vat' => 'BE0405912336'],
        ['name' => 'S.W.I.F.T. scrl', 'address' => 'Avenue Adèle 1', 'zip' => 1310, 'city' => 'La Hulpe', 'activity' => 'Wireless telecommunications activities', 'vat' => 'BE0413330856'],
        ['name' => 'G4S Secure Solutions', 'address' => 'Esplanade 1/77', 'zip' => 1020, 'city' => 'Bruxelles', 'activity' => 'Specialised construction activities', 'vat' => 'BE0411519431'],
        ['name' => 'Care', 'address' => 'Luchthavenlei 7b 2', 'zip' => 2100, 'city' => 'Deurne', 'activity' => 'Specialised construction activities', 'vat' => 'BE0414097156'],
        ['name' => 'Alcatel-Lucent Bell', 'address' => 'Copernicuslaan 50', 'zip' => 2018, 'city' => 'Antwerpen', 'activity' => 'Manufacture of communication equipment', 'vat' => 'BE0404621642'],
        ['name' => 'SGS Belgium', 'address' => 'Noorderlaan 87', 'zip' => 2030, 'city' => 'Antwerpen', 'activity' => 'Construction of water projects', 'vat' => 'BE0404882750'],
        ['name' => 'Brussels Airlines', 'address' => 'Jaargetijdenlaan 100/30-102', 'zip' => 1050, 'city' => 'Brussel', 'activity' => 'Passenger air transport', 'vat' => 'BE0400853488'],
        ['name' => 'Zeeman textielSupers', 'address' => 'Bredabaan 498', 'zip' => 2170, 'city' => 'Merksem', 'activity' => 'Retail sale of textiles in specialised stores', 'vat' => 'BE0437177416'],
        ['name' => 'Iss Facility Services', 'address' => 'Rue du Congrès 35', 'zip' => 1000, 'city' => 'Bruxelles', 'activity' => 'Construction of residential and non-residential buildings', 'vat' => 'BE0403313330'],
        ['name' => 'NV BEKAERT SA', 'address' => 'Bekaertstraat 2', 'zip' => 8550, 'city' => 'Zwevegem', 'activity' => 'Manufacture of basic metals', 'vat' => 'BE0405388536'],
        ['name' => 'Tenneco Automotive Europe', 'address' => 'Industriezone Schurhovenveld 1037', 'zip' => 3800, 'city' => 'Sint-Truiden', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0403684997'],
        ['name' => 'Ford Werke Gmbh', 'address' => 'Henry Fordlaan 8', 'zip' => 3600, 'city' => 'Genk', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0401298403'],
        ['name' => 'CITADELLE', 'address' => 'Boulevard du Douzième de Ligne 1', 'zip' => 4000, 'city' => 'Liège', 'activity' => 'Service activities incidental to land transportation', 'vat' => 'BE0237086311'],
        ['name' => 'Clinique Maternité Sainte-Elisabeth', 'address' => 'Place Louise Godin 15', 'zip' => 5000, 'city' => 'Namur', 'activity' => 'Dispensing chemist in specialised stores', 'vat' => 'BE0420404433'],
        ['name' => 'C.H.R.H.', 'address' => 'Rue des Trois Ponts 2', 'zip' => 4500, 'city' => 'Huy', 'activity' => 'Dispensing chemist in specialised stores', 'vat' => 'BE0237224881'],
        ['name' => 'Umicore', 'address' => 'Rue du Marais 31', 'zip' => 1000, 'city' => 'Bruxelles', 'activity' => 'Manufacture of other organic basic chemicals', 'vat' => 'BE0401574852'],
        ['name' => 'SONACA', 'address' => 'Route Nationale 5 0', 'zip' => 6041, 'city' => 'Gosselies', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0418217577'],
        ['name' => 'Centre Hospit. Univ. et Psychiat.', 'address' => 'Boulevard Président Kennedy 2', 'zip' => 7000, 'city' => 'Mons', 'activity' => 'Dispensing chemist in specialised stores', 'vat' => 'BE0440868364'],
        ['name' => 'Quality Meat Renmans', 'address' => 'Place de Saint-Symphorien 2', 'zip' => 7030, 'city' => 'Saint-Symphorien', 'activity' => 'Retail sale of meat and meat products in specialised stores', 'vat' => 'BE0427275991'],
        ['name' => 'CNH Industrial Belgium', 'address' => 'Léon Claeysstraat 3A', 'zip' => 8210, 'city' => 'Zedelgem', 'activity' => 'Manufacture of metal structures and parts of structures', 'vat' => 'BE0400444803'],
        ['name' => 'Westvlees', 'address' => 'Ommegang West 9', 'zip' => 8840, 'city' => 'Westrozebeke', 'activity' => 'Processing and preserving of meat', 'vat' => 'BE0442637526'],
        ['name' => 'Coca-Cola Enterprises Belgium', 'address' => 'Chaussée de Mons 1424', 'zip' => 1070, 'city' => 'Bruxelles', 'activity' => 'Manufacture of food products', 'vat' => 'BE0425071420'],
        ['name' => 'Arcelormittal Belgium', 'address' => 'Keizerinlaan 66', 'zip' => 1000, 'city' => 'Brussel', 'activity' => 'Manufacture of basic metals', 'vat' => 'BE0400106291'],
        ['name' => 'Actief Interim', 'address' => 'Bosstraat 67/2', 'zip' => 3560, 'city' => 'Lummen', 'activity' => 'Specialised construction activities', 'vat' => 'BE0433344035'],
        ['name' => 'Recticel', 'address' => 'Olympiadenlaan 2', 'zip' => 1140, 'city' => 'Brussel', 'activity' => 'Manufacture of plastic plates, sheets, tubes and profiles', 'vat' => 'BE0405666668'],
        ['name' => 'Cleaning Masters', 'address' => 'Westkaai 11', 'zip' => 2170, 'city' => 'Merksem', 'activity' => 'Specialised construction activities', 'vat' => 'BE0435474471'],
        ['name' => 'T.E.C. Liège-Verviers', 'address' => 'Rue du Bassin 119', 'zip' => 4030, 'city' => 'Grivegnée', 'activity' => 'Land transport and transport via pipelines', 'vat' => 'BE0242319658'],
        ['name' => 'VIVALDIS INTERIM', 'address' => 'Frankrijklei 126', 'zip' => 2000, 'city' => 'Antwerpen', 'activity' => 'Specialised construction activities', 'vat' => 'BE0443052646'],
        ['name' => 'Kruidvat', 'address' => 'Meir 21', 'zip' => 2000, 'city' => 'Antwerpen', 'activity' => 'Other retail sale in non-specialised stores', 'vat' => 'BE0446891668'],
        ['name' => 'Balta Industries', 'address' => 'Wakkensteenweg 2', 'zip' => 8710, 'city' => 'Sint-Baafs-Vijve', 'activity' => 'Weaving of textiles', 'vat' => 'BE0441533409'],
        ['name' => 'Volvo Group Belgium', 'address' => 'Smalleheerweg 31', 'zip' => 9041, 'city' => 'Oostakker', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0420383647'],
        ['name' => 'Securitas', 'address' => 'Font Saint-Landry 3', 'zip' => 1120, 'city' => 'Bruxelles', 'activity' => 'Private security activities', 'vat' => 'BE0427388334'],
        ['name' => 'Unilin', 'address' => 'Ooigemstraat 3', 'zip' => 8710, 'city' => 'Wielsbeke', 'activity' => 'Manufacture of veneer sheets and wood-based panels', 'vat' => 'BE0405414072'],
        ['name' => 'Havenbedrijf Antwerpen', 'address' => 'Entrepotkaai 1', 'zip' => 2000, 'city' => 'Antwerpen', 'activity' => 'Service activities incidental to water transportation', 'vat' => 'BE0248399380'],
        ['name' => 'New Vanden Borre', 'address' => 'Slesbroekstraat 101', 'zip' => 1600, 'city' => 'Sint-Pieters-Leeuw', 'activity' => 'Wholesale of electrical household appliances', 'vat' => 'BE0412723419'],
        ['name' => 'Spie Belgium', 'address' => 'Rue des Deux Gares 150', 'zip' => 1070, 'city' => 'Bruxelles', 'activity' => 'Manufacture of metal structures and parts of structures', 'vat' => 'BE0434499028'],
        ['name' => 'FN Herstal', 'address' => 'Voie de Liège 33', 'zip' => 4040, 'city' => 'Herstal', 'activity' => 'Manufacture of weapons and ammunition', 'vat' => 'BE0441928931'],
        ['name' => 'Safran Aero Boosters', 'address' => 'Route de Liers 121', 'zip' => 4041, 'city' => 'Milmort', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0432618812'],
        ['name' => 'Euroclean', 'address' => 'Boulevard International 55F', 'zip' => 1070, 'city' => 'Bruxelles', 'activity' => 'Construction of other civil engineering projects n.e.c.', 'vat' => 'BE0453203301'],
        ['name' => 'Toyota Motor Europe', 'address' => 'Avenue du Bourget 60', 'zip' => 1140, 'city' => 'Bruxelles', 'activity' => 'Sale of cars and light motor vehicles', 'vat' => 'BE0441571714'],
        ['name' => 'VVM - De Lijn', 'address' => 'Motstraat 20', 'zip' => 2800, 'city' => 'Mechelen', 'activity' => 'Land transport and transport via pipelines', 'vat' => 'BE0242069537'],
        ['name' => 'Wienerberger', 'address' => 'Kapel ter Bede 121', 'zip' => 8500, 'city' => 'Kortrijk', 'activity' => 'Manufacture of bricks, tiles and construction products, in baked clay', 'vat' => 'BE0448850870'],
        ['name' => 'H & M Hennes & Mauritz', 'address' => 'Prinsenstraat 8', 'zip' => 1000, 'city' => 'Brussel', 'activity' => 'Wholesale of textiles', 'vat' => 'BE0465925741'],
        ['name' => 'VOLVO CAR BELGIUM NV', 'address' => 'John Kennedylaan 25', 'zip' => 9000, 'city' => 'Gent', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0420383548'],
        ['name' => 'Total Raffinaderij Antwerpen', 'address' => 'Scheldelaan 16', 'zip' => 2030, 'city' => 'Antwerpen', 'activity' => 'Manufacture of refined petroleum products', 'vat' => 'BE0404586901'],
        ['name' => 'ISoSL', 'address' => 'Rue Basse-Wez 145', 'zip' => 4020, 'city' => 'Liège', 'activity' => 'Dispensing chemist in specialised stores', 'vat' => 'BE0250610881'],
        ['name' => 'Zara Belgique - Zara Belgie', 'address' => 'Rue du Marais 49/53', 'zip' => 1000, 'city' => 'Bruxelles', 'activity' => 'Wholesale of textiles', 'vat' => 'BE0450661802'],
        ['name' => 'Gom', 'address' => 'Noorderplaats 7/1', 'zip' => 2000, 'city' => 'Antwerpen', 'activity' => 'Specialised construction activities', 'vat' => 'BE0414600566'],
        ['name' => 'Barco', 'address' => 'President Kennedypark 35', 'zip' => 8500, 'city' => 'Kortrijk', 'activity' => 'Manufacture of electronic components', 'vat' => 'BE0473191041'],
        ['name' => 'Krëfel', 'address' => 'Steenstraat 44', 'zip' => 1851, 'city' => 'Humbeek', 'activity' => 'Specialised construction activities', 'vat' => 'BE0400673544'],
        ['name' => 'SOCIETE WALLONNE DES  EAUX', 'address' => 'Rue de la Concorde 41', 'zip' => 4800, 'city' => 'Verviers', 'activity' => 'Electric power generation, transmission and distribution', 'vat' => 'BE0230132005'],
        ['name' => 'Vedior Interim', 'address' => 'Keizer Karellaan 586/8', 'zip' => 1082, 'city' => 'Brussel', 'activity' => 'Specialised construction activities', 'vat' => 'BE0428327551'],
        ['name' => 'Siemens', 'address' => 'Guido Gezellestraat 123', 'zip' => 1654, 'city' => 'Huizingen', 'activity' => 'Manufacture of communication equipment', 'vat' => 'BE0404284716'],
        ['name' => 'Belfius Banque', 'address' => 'Boulevard Pachéco 44', 'zip' => 1000, 'city' => 'Bruxelles', 'activity' => 'Publishing of journals and periodicals', 'vat' => 'BE0403201185'],
        ['name' => 'Cofely Services', 'address' => 'Boulevard du Roi Albert II 30/28', 'zip' => 1000, 'city' => 'Bruxelles', 'activity' => 'Manufacture of non-domestic cooling and ventilation equipment', 'vat' => 'BE0402947797'],
        ['name' => 'McBride', 'address' => 'Rue du Moulin Masure 6', 'zip' => 7730, 'city' => 'Estaimpuis', 'activity' => 'Manufacture of soap and detergents, cleaning and polishing preparations', 'vat' => 'BE0403984016'],
        ['name' => 'Alcon - Couvreur', 'address' => 'Rijksweg 14', 'zip' => 2870, 'city' => 'Puurs', 'activity' => 'Manufacture of chemicals and chemical products', 'vat' => 'BE0402134977'],
        ['name' => 'Janssen Pharmaceutica', 'address' => 'Turnhoutseweg 30', 'zip' => 2340, 'city' => 'Beerse', 'activity' => 'Manufacture of chemicals and chemical products', 'vat' => 'BE0403834160'],
        ['name' => 'Daikin Europe', 'address' => 'Zandvoordestraat 300', 'zip' => 8400, 'city' => 'Oostende', 'activity' => 'Manufacture of non-domestic cooling and ventilation equipment', 'vat' => 'BE0412120336'],
        ['name' => 'Caterpillar Belgium', 'address' => 'Avenue des Etats-Unis 1', 'zip' => 6041, 'city' => 'Gosselies', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0401633250'],
        ['name' => 'Daoust', 'address' => 'Galerie de la Porte Louise 203/5', 'zip' => 1050, 'city' => 'Bruxelles', 'activity' => 'Specialised construction activities', 'vat' => 'BE0400523292'],
        ['name' => 'Baxter', 'address' => 'Boulevard René Branquart 80', 'zip' => 7860, 'city' => 'Lessines', 'activity' => 'Manufacture of chemicals and chemical products', 'vat' => 'BE0403093693'],
        ['name' => 'Sodexo Belgium SA', 'address' => 'Boulevard de la Plaine 15', 'zip' => 1050, 'city' => 'Bruxelles', 'activity' => 'Specialised construction activities', 'vat' => 'BE0407246778'],
        ['name' => 'S.T.I.B.', 'address' => 'Rue Royale 76', 'zip' => 1000, 'city' => 'Bruxelles', 'activity' => 'Land transport and transport via pipelines', 'vat' => 'BE0247499953'],
        ['name' => 'TVH Parts', 'address' => 'Brabantstraat 15', 'zip' => 8790, 'city' => 'Waregem', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0425399042'],
        ['name' => 'AGC  GLASS EUROPE', 'address' => 'Avenue Jean Monnet 4', 'zip' => 1348, 'city' => 'Louvain-la-Neuve', 'activity' => 'Manufacture of flat glass', 'vat' => 'BE0413638187'],
        ['name' => 'Ontex', 'address' => 'Genthof 5', 'zip' => 9255, 'city' => 'Buggenhout', 'activity' => 'Manufacture of household and sanitary goods and of toilet requisites', 'vat' => 'BE0419457296'],
        ['name' => 'Pfizer Manufacturing Belgium', 'address' => 'Rijksweg 12', 'zip' => 2870, 'city' => 'Puurs', 'activity' => 'Manufacture of chemicals and chemical products', 'vat' => 'BE0400778165'],
        ['name' => 'Jobmatch', 'address' => 'Internationalelaan 55F', 'zip' => 1070, 'city' => 'Brussel', 'activity' => 'Specialised construction activities', 'vat' => 'BE0418737419'],
        ['name' => 'Robert Bosch Produktie', 'address' => 'Hamelendreef 80', 'zip' => 3300, 'city' => 'Tienen', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0407251926'],
        ['name' => 'B.A.S.F. Antwerpen N.V.', 'address' => 'Scheldelaan 600', 'zip' => 2040, 'city' => 'Antwerpen', 'activity' => 'Manufacture of other organic basic chemicals', 'vat' => 'BE0404754472'],
        ['name' => 'GlaxoSmithKline Biologicals', 'address' => 'Rue de l Institut 89', 'zip' => 1330, 'city' => 'Rixensart', 'activity' => 'Manufacture of chemicals and chemical products', 'vat' => 'BE0440872918'],
        ['name' => 'Jan De Nul', 'address' => 'Tragel 60', 'zip' => 9308, 'city' => 'Hofstade', 'activity' => 'Manufacture of metal structures and parts of structures', 'vat' => 'BE0406041406'],
        ['name' => 'Laurenty', 'address' => 'Mont Saint-Martin 73', 'zip' => 4000, 'city' => 'Liège', 'activity' => 'Construction of residential and non-residential buildings', 'vat' => 'BE0402349862'],
        ['name' => 'Centre Hospitalier Chretien', 'address' => 'Rue de Hesbaye 75', 'zip' => 4000, 'city' => 'Liège', 'activity' => 'Dispensing chemist in specialised stores', 'vat' => 'BE0416805238'],
        ['name' => 'Centr. Werkg. Haven Antw.', 'address' => 'Brouwersvliet 33/7', 'zip' => 2000, 'city' => 'Antwerpen', 'activity' => 'Cargo handling', 'vat' => 'BE0404759323'],
        ['name' => 'Van Hool', 'address' => 'Bernard Van Hoolstraat 58', 'zip' => 2500, 'city' => 'Koningshooikt', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0404060032'],
        ['name' => 'Robert Half', 'address' => 'Alfons Gossetlaan 28A 7', 'zip' => 1702, 'city' => 'Groot-Bijgaarden', 'activity' => 'Temporary employment agency activities', 'vat' => 'BE0440965760'],
        ['name' => 'Manpower (Belgium)', 'address' => 'Avenue Louise 523', 'zip' => 1050, 'city' => 'Bruxelles', 'activity' => 'Specialised construction activities', 'vat' => 'BE0412695309'],
        ['name' => 'Iris Cleaning Services', 'address' => 'Avenue de Bâle 5', 'zip' => 1140, 'city' => 'Bruxelles', 'activity' => 'Specialised construction activities', 'vat' => 'BE0453520233'],
        ['name' => 'Audi Brussels', 'address' => 'Bd d.l. 2ème Armée Britannique 201', 'zip' => 1190, 'city' => 'Bruxelles', 'activity' => 'Manufacture of fabricated metal products, except machinery and equipment', 'vat' => 'BE0407687238'],
        ['name' => 'Evonik DEGUSSA Antwerpen', 'address' => 'Tijsmanstunnel West 0', 'zip' => 2040, 'city' => 'Antwerpen', 'activity' => 'Manufacture of other organic basic chemicals', 'vat' => 'BE0406183144'],
        ['name' => 'Makro Cash & Carry Belgium', 'address' => 'Nijverheidsstraat 70', 'zip' => 2160, 'city' => 'Wommelgem', 'activity' => 'Wholesale of food, beverages and tobacco', 'vat' => 'BE0406952018'],
        ['name' => 'Synergie Belgium', 'address' => 'Desguinlei 88-90', 'zip' => 2018, 'city' => 'Antwerpen', 'activity' => 'Specialised construction activities', 'vat' => 'BE0458551563'],
        ['name' => 'TNT Express Worldwide', 'address' => 'Rue de l Aéroport 90', 'zip' => 4460, 'city' => 'Hollogne-aux-Pierres', 'activity' => 'Passenger air transport', 'vat' => 'BE0458858302'],
        ['name' => 'Randstad Household Services', 'address' => 'Keizer Karellaan 586/8', 'zip' => 1082, 'city' => 'Brussel', 'activity' => 'Activities of employment placement agencies', 'vat' => 'BE0467127056'],
        ['name' => 'Eandis System Operator', 'address' => 'Brusselsesteenweg 199', 'zip' => 9090, 'city' => 'Melle', 'activity' => 'Production of electricity', 'vat' => 'BE0477445084'],
        ['name' => 'T - Groep', 'address' => 'Stationsstraat 120', 'zip' => 2800, 'city' => 'Mechelen', 'activity' => 'Specialised construction activities', 'vat' => 'BE0478971449'],
        ['name' => 'Aldron', 'address' => 'Gentse Heerweg 42', 'zip' => 8790, 'city' => 'Waregem', 'activity' => 'General cleaning of buildings', 'vat' => 'BE0870933405'],
        ['name' => 'Randstad Group Belgium', 'address' => 'Keizer Karellaan 586/8', 'zip' => 1082, 'city' => 'Brussel', 'activity' => 'Temporary employment agency activities', 'vat' => 'BE0874753819'],
        ['name' => 'Ancco Dienstencheques', 'address' => 'Bisschoppenhoflaan 297/1', 'zip' => 2100, 'city' => 'Deurne', 'activity' => 'Activities of employment placement agencies', 'vat' => 'BE0880511461'],
        ['name' => 'Smals', 'address' => 'Avenue Fonsny 20', 'zip' => 1060, 'city' => 'Bruxelles', 'activity' => 'Data processing, hosting and related activities', 'vat' => 'BE0406798006'],
        ['name' => 'Fabricom', 'address' => 'Boulevard Simon Bolivar 34-36', 'zip' => 1000, 'city' => 'Bruxelles', 'activity' => 'Manufacture of metal structures and parts of structures', 'vat' => 'BE0425702910']];

if (array_key_exists('sort', $_GET) && ($_GET['sort'] === 'zip')){
    function zipCompare($a, $b) {
        return strcmp($a['zip'], $b['zip']);
    }
    usort($companies, 'zipCompare');
}
?><!DOCTYPE html>
<html>
<head>
    <title>Voka - bedrijfslijst</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--[if lte IE 8]>
    <script src="js/ie/html5shiv.js"></script><![endif]-->
    <link rel="stylesheet" href="css/main.css" />
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="css/ie8.css"/><![endif]-->

    <!-- Scripts -->
    <script src="js/jquery.min.js"></script>
    <script src="js/jquery.poptrox.min.js"></script>
    <script src="js/skel.min.js"></script>
    <script src="js/util.js"></script>
    <!--[if lte IE 8]>
    <script src="js/ie/respond.min.js"></script><![endif]-->
    <script src="js/main.js"></script>
</head>
<body id="top">

<!-- Header -->
<header id="header">
    <h1><a href="index.php"><strong>voka</strong></a></h1>
    <h1>Vlaams netwerk van ondernemingen</h1>
</header>

<!-- Main -->
<div id="main">
    <!-- Welcome -->
    <section id="welcome">
        <header class="major">
            <h2>Overzicht bedrijven</h2>
        </header>
        <p>Hieronder vindt u een overzicht van alle grote bedrijven uit Oost-Vlaanderen in onze databank.</p>
        <ul class="actions">
            <li><a href="#" class="button special disabled">Registreren</a></li>
            <li><a href="#" class="button special">Inloggen</a></li>
        </ul>
    </section>

    <!-- Event table -->
    <section id="event_table">
        <div class="table-wrapper">
            <table class="alt">
                <thead>
                <tr>
                    <th>Naam</th>
                    <th>Straat en nummer</th>
                    <th>Postcode en gemeente</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($companies as $company) { ?>
                <tr>
                    <td><?php echo $company['name']; ?></td>
                    <td><?php echo $company['address']; ?></td>
                    <td><?php echo $company['name'] . ' ' . $company['city']; ?></td>
                </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </section>
</div>

<!-- Footer -->
<footer id="footer">
    <ul class="icons">
        <li><a href="http://www.events.be/" class="icon fa-globe"><span class="label">Website</span></a></li>
        <li><a href="mailto:info@events.be" class="icon fa-envelope-o"><span class="label">Email</span></a></li>
    </ul>
    <ul class="copyright">
        <li>&copy; <a href="http://www.ikdoeict.be/" title="IkDoeICT.be">IkDoeICT.be</a></li>
        <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
    </ul>
</footer>



</body>
<div id="debug">

    <?php

    /**
     * Helper Functions
     * ========================
     */

    /**
     * Dumps a variable
     * @param mixed $var
     * @return void
     */
    function dump($var) {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }


    /**
     * Main Program Code
     * ========================
     */

    // dump $_GET
    dump($companies);

    //dump($pureData);

    ?>

</div>
</html>