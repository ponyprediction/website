db = connect("ponyprediction");
db.texts.drop();
db.texts.createIndex({"id":1}, {unique:true});
