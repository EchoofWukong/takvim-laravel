import sys, json, pdfplumber, re

def normalize_text(text):
    text = str(text).lower().strip()
    replacements = {'ö': 'o', 'ü': 'u', 'ı': 'i', 'i̇': 'i', 'ş': 's', 'ç': 'c', 'ğ': 'g'}
    for tr, eng in replacements.items(): text = text.replace(tr, eng)
    return text

def main():
    sys.stdout.reconfigure(encoding='utf-8')
    if len(sys.argv) < 5:
        print(json.dumps({"error": "Eksik parametre"}))
        return
        
    pdf_path, teacher_name, is_exam, import_all = sys.argv[1], sys.argv[2], sys.argv[3] == "true", sys.argv[4] == "true"
    extracted = []
    days_keywords = ['pazartesi', 'salı', 'çarşamba', 'perşembe', 'cuma', 'cumartesi', 'pazar', 'sali', 'carsamba', 'persembe']
    ignore_titles = ['öğr', 'gör', 'dr', 'prof', 'doç', 'üyesi']
    teacher_parts = [normalize_text(p) for p in teacher_name.split() if p.lower() not in ignore_titles]

    try:
        with pdfplumber.open(pdf_path) as pdf:
            for page in pdf.pages:
                tables = page.extract_tables()
                for table in tables:
                    if not table: continue
                    
                    day_columns = {}
                    start_row_idx = 0
                    
                    # Başlıkları ve tam tarihleri hatasız birleştirerek bul
                    for row_idx, row in enumerate(table):
                        found_day = False
                        for col_idx, cell in enumerate(row):
                            if cell:
                                # Tüm satır atlamalarını tek boşluğa çevir (Örn: Pazartesi \n 8 Haziran -> Pazartesi 8 Haziran)
                                cell_str = " ".join(str(cell).split())
                                if any(d in normalize_text(cell_str) for d in days_keywords):
                                    day_columns[col_idx] = cell_str 
                                    found_day = True
                        if found_day:
                            start_row_idx = row_idx + 1
                            break
                    
                    if not day_columns: continue
                    
                    for row in table[start_row_idx:]:
                        if not row or not row[0]: continue
                        time_str = str(row[0]).replace('.', ':').strip()
                        times = re.findall(r'\d{2}:\d{2}', time_str)
                        if len(times) < 2: continue
                        
                        start_time, end_time = times[0], times[-1]
                        
                        for col_idx, cell in enumerate(row):
                            if col_idx in day_columns and cell:
                                clean_cell = normalize_text(str(cell).replace('\n', ' '))
                                should_add = import_all or all(p in clean_cell for p in teacher_parts)
                                
                                if should_add:
                                    lines = [line.strip() for line in str(cell).split('\n') if line.strip()]
                                    if not lines: continue
                                    
                                    subject = lines[0]
                                    classroom = "Bilinmiyor"
                                    
                                    # Eğer ikinci bir satır varsa ve hoca ismi değilse, direkt sınıf kabul et
                                    if len(lines) > 1:
                                        for line in lines[1:]:
                                            l_norm = normalize_text(line)
                                            if not any(t in l_norm for t in ignore_titles + teacher_parts):
                                                classroom = line
                                                break
                                            
                                    extracted.append({
                                        "type": "exam" if is_exam else "lesson",
                                        "day": day_columns[col_idx],
                                        "start_time": start_time,
                                        "end_time": end_time,
                                        "subject": subject,
                                        "classroom": classroom
                                    })
        print(json.dumps(extracted))
    except Exception as e:
        print(json.dumps({"error": str(e)}))

if __name__ == "__main__": main()