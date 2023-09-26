Gestion de collection de génériques d'animé japonais

[objet]			generique
[inventaire]		album
[galerie]		playlist

Propiété de generique
Propriété	Type		Contraintes		Commentaire
titre		String		notnull			Titre de la musique
artiste         String          notnull                 Artiste de la musique
anime		String		notnull			Animé d'où est tiré le générique
type		String		notnull			"Opening" ou "Ending"
numero		int		notnull			Numéro du générique


Propriété d'album
Propriété       Type            Contraintes             Commentaire
description	String		notnull



Propriété de member
Propriété       Type            Contraintes             Commentaire
nom		String		notnull
description	String		nullable


Associations
album	(1) --- (0..n)	generique
member	(1) --- (0..n)	album
