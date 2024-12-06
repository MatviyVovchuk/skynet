from pymilvus import connections, db

conn = connections.connect(host="localhost", port=19530)

database = db.create_database("skynet")
