from flask import Flask, request, jsonify
from flask_cors import CORS
from textblob import TextBlob

app = Flask(__name__)
CORS(app)  # Enable CORS for all routes

def analyze_sentiment(text):
    """Analyze sentiment of the text and return polarity and sentiment label"""
    analysis = TextBlob(text)
    polarity = analysis.sentiment.polarity
    
    if polarity > 0.1:
        sentiment = "positive"
        emoji = "😊"
    elif polarity < -0.1:
        sentiment = "negative"
        emoji = "😞"
    else:
        sentiment = "neutral"
        emoji = "😐"
    
    return {
        "polarity": round(polarity, 3),
        "sentiment": sentiment,
        "emoji": emoji,
        "subjectivity": round(analysis.sentiment.subjectivity, 3)
    }

@app.route('/health', methods=['GET'])
def health_check():
    return jsonify({"status": "healthy", "service": "sentiment-analysis"})

@app.route('/analyze', methods=['POST'])
def analyze_text():
    try:
        data = request.get_json()
        
        if not data or 'text' not in data:
            return jsonify({"error": "No text provided"}), 400
        
        text = data['text']
        
        if len(text.strip()) == 0:
            return jsonify({"error": "Text cannot be empty"}), 400
        
        result = analyze_sentiment(text)
        
        return jsonify({
            "text": text,
            "analysis": result,
            "status": "success"
        })
        
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)