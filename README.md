---
title: irisa-and-you
emoji: 🌍
colorFrom: gray
colorTo: indigo
sdk: docker
pinned: false
short_description: Serveur web pour R410
license: mit
---

# r410 &mdash; IRISA And You <!-- markdownlint-disable-line MD025 -->

<https://5cover-r410.hf.space/>

IRISA research.

Pour exécuter le projet `/src$ php spark serve`

## Todo

###

<https://globe.gl/>

### Setup DB on 413 ventsdouest (test locally)

- ventsdouest SSH publickey
- db creation script

### gouv gelocoding fr api

`$ curl "https://api-adresse.data.gouv.fr/search/?q=LIFL+Lille+France&limit=1"`

```json
{
  "type": "FeatureCollection",
  "features": [
    {
      "type": "Feature",
      "geometry": {
        "type": "Point",
        "coordinates": [
          3.051899,
          50.63018
        ]
      },
      "properties": {
        "label": "Rue Franklin (Lille) 59800 Lille",
        "score": 0.4666463636363636,
        "id": "59350_3587",
        "banId": "94ab6e3f-eba0-4eca-b3b6-c580a5c9fc31",
        "name": "Rue Franklin (Lille)",
        "postcode": "59800",
        "citycode": "59350",
        "oldcitycode": "59350",
        "x": 703678.28,
        "y": 7059245.53,
        "city": "Lille",
        "oldcity": "Lille",
        "context": "59, Nord, Hauts-de-France",
        "type": "street",
        "importance": 0.63311,
        "street": "Rue Franklin (Lille)",
        "_type": "address"
      }
    }
  ]
}
```

### Hal

<https://api.archives-ouvertes.fr/search/IRISA/>

todo: build map for irisa collaborations

1. read countries csv
2. read collaborations csv
3. map countries to lat/lon
4. add sized circles to map on the center of each country
