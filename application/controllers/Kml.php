<?php
class kml extends CI_Controller {

    const XmlStart ='<?xml version="1.0" encoding="UTF-8"?>
<kml xmlns="http://www.opengis.net/kml/2.2">
  <Document>
    <name>oshun</name>
    <description/>
    <Style id="icon-1899-DB4436-nodesc-normal">
      <IconStyle>
        <color>ff3644db</color>
        <scale>1</scale>
        <Icon>
          <href>http://www.gstatic.com/mapspro/images/stock/503-wht-blank_maps.png</href>
        </Icon>
        <hotSpot x="32" xunits="pixels" y="64" yunits="insetPixels"/>
      </IconStyle>
      <LabelStyle>
        <scale>0</scale>
      </LabelStyle>
      <BalloonStyle>
        <text><![CDATA[<h3>$[name]</h3>]]></text>
      </BalloonStyle>
    </Style>
    <Style id="icon-1899-DB4436-nodesc-highlight">
      <IconStyle>
        <color>ff3644db</color>
        <scale>1</scale>
        <Icon>
          <href>http://www.gstatic.com/mapspro/images/stock/503-wht-blank_maps.png</href>
        </Icon>
        <hotSpot x="32" xunits="pixels" y="64" yunits="insetPixels"/>
      </IconStyle>
      <LabelStyle>
        <scale>1</scale>
      </LabelStyle>
      <BalloonStyle>
        <text><![CDATA[<h3>$[name]</h3>]]></text>
      </BalloonStyle>
    </Style>
    <StyleMap id="icon-1899-DB4436-nodesc">
      <Pair>
        <key>normal</key>
        <styleUrl>#icon-1899-DB4436-nodesc-normal</styleUrl>
      </Pair>
      <Pair>
        <key>highlight</key>
        <styleUrl>#icon-1899-DB4436-nodesc-highlight</styleUrl>
      </Pair>
    </StyleMap>
    <Style id="line-1267FF-5000-nodesc-normal">
      <LineStyle>
        <color>ffff6712</color>
        <width>5</width>
      </LineStyle>
      <BalloonStyle>
        <text><![CDATA[<h3>$[name]</h3>]]></text>
      </BalloonStyle>
    </Style>
    <Style id="line-1267FF-5000-nodesc-highlight">
      <LineStyle>
        <color>ffff6712</color>
        <width>7.5</width>
      </LineStyle>
      <BalloonStyle>
        <text><![CDATA[<h3>$[name]</h3>]]></text>
      </BalloonStyle>
    </Style>
    <StyleMap id="line-1267FF-5000-nodesc">
      <Pair>
        <key>normal</key>
        <styleUrl>#line-1267FF-5000-nodesc-normal</styleUrl>
      </Pair>
      <Pair>
        <key>highlight</key>
        <styleUrl>#line-1267FF-5000-nodesc-highlight</styleUrl>
      </Pair>
    </StyleMap>
    <Folder>
      <name>Untitled layer</name>
    </Folder>
    <Folder>
';
    public $protocol = '';
    private $pdo,
        $kmlText,
        $locations,
        $routeId,
        $routeName;

    function __construct() {
       
        parent::__construct();
       // $this->is_logged_in();
		$this->load->model('Parade_model');
		//$this->load->helper('url');
		$this->protocol = isset($_SERVER["HTTPS"]) ? 'https' : 'http';
        date_default_timezone_set('America/Chicago');
    }

    function getLocations() {
        
        $this->locations = array();
        $this->locations = (object)$this->Parade_model->kmlData($this->routeId);
    }

    function kmlName() {
        $name = '<name>' . htmlspecialchars($this->routeName, ENT_XML1, 'UTF-8') . '</name>' . PHP_EOL;
        $this->kmlText .= $name . '<Placemark>' . $name;
        $this->kmlText .= '<styleUrl>#line-1267FF-5000-nodesc</styleUrl>' . PHP_EOL;
        $this->kmlText .= '<LineString>' . PHP_EOL;
        $this->kmlText .= '<tessellate>1</tessellate>' . PHP_EOL;
        $this->kmlText .= '<coordinates>' . PHP_EOL;


        foreach ($this->locations as $location) {
            $this->kmlText .= $location->longitude . ',' . $location->latitude . ',0' . PHP_EOL;
            
        }

        $this->kmlText .= '</coordinates>' . PHP_EOL;
        $this->kmlText .= '</LineString>' . PHP_EOL;
        $this->kmlText .= '</Placemark>' . PHP_EOL;
    }

    function kmlPlaceMarks() {
        foreach ($this->locations as $location) {
            $this->kmlText .= '<Placemark>' . PHP_EOL;
            $this->kmlText .= '<name>' . htmlspecialchars($location->intersection, ENT_XML1, 'UTF-8') . '</name>' . PHP_EOL;
            $this->kmlText .= '<styleUrl>#icon-1899-DB4436-nodesc</styleUrl>' . PHP_EOL;
            $this->kmlText .= '<Point>' . PHP_EOL;
            $this->kmlText .= '<coordinates>' . PHP_EOL;
            $this->kmlText .= $location->longitude . ',' . $location->latitude . ',0' . PHP_EOL;
            $this->kmlText .= '</coordinates>' . PHP_EOL;
            $this->kmlText .= '</Point>' . PHP_EOL;
            $this->kmlText .= '</Placemark>' . PHP_EOL;
        }
    }
    
    function kmlFinish() {
        $this->kmlText .= '</Folder>' . PHP_EOL;
        $this->kmlText .= '</Document>' . PHP_EOL;
        $this->kmlText .= '</kml>' . PHP_EOL;
    }
    
    function save($routeName, $routeId) {
        $this->routeId = $routeId;
        $this->routeName = $routeName;
       
        $this->getLocations();
        $this->kmlText = $this::XmlStart;
        $this->kmlName();
        $this->kmlPlaceMarks();
        $this->kmlFinish();
        header('HTTP/1.1 200 OK');
        header('Content-Type: application/xml');
        header('Content-Length: ' . strlen($this->kmlText));
        echo $this->kmlText;
    }
    
    function kmlfile(){
        $id = filter_var($this->uri->segment(3), FILTER_VALIDATE_INT);
        $name = $this->uri->segment(4);
        
        if(!$id)            return FALSE;
        $this->save($name, $id);
    }
}
